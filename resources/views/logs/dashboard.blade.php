@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row mb-3">
    <div class="col">
      <h2 class="mb-0">Dashboard</h2>
      <small class="text-muted">Crack Detection Monitoring</small>
    </div>
  </div>
  <!-- Stats cards -->
  <div class="row g-3 mb-3">
    <div class="col-6 col-lg-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center bg-danger-subtle">
          <div class="me-3 text-danger"><i class="fas fa-exclamation-triangle fa-lg"></i></div>
          <div>
            <div class="h4 mb-0 text-danger">{{ $totalDetected ?? 0 }}</div>
            <small class="text-muted">Detected Total</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center bg-warning-subtle">
          <div class="me-3 text-warning"><i class="fas fa-desktop fa-lg"></i></div>
          <div>
            <div class="h4 mb-0 text-warning">{{ $totalPCs ?? 0 }}</div>
            <small class="text-muted">PC Detected</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center bg-info-subtle">
          <div class="me-3 text-info"><i class="fas fa-users fa-lg"></i></div>
          <div>
            <div class="h4 mb-0 text-info">{{ $totalUsers ?? 0 }}</div>
            <small class="text-muted">Users Engage</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="card h-100">
        <div class="card-body d-flex align-items-center bg-success-subtle">
          <div class="me-3 text-success"><i class="fas fa-info-circle fa-lg"></i></div>
          <div>
            <div class="h4 mb-0 text-success">{{ $totalApps ?? 0 }}</div>
            <small class="text-muted">Application Type</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3">
    <div class="col-12 col-lg-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Detections (last 7 days)</h5>
          <canvas id="detectionsChart" height="140"></canvas>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Top PCs by Detections (last 7 days)</h5>
            <div>
              <label class="me-1 small">Limit</label>
              <select id="pcChartLimit" class="form-select form-select-sm d-inline-block" style="width:auto;">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
                <option value="20">20</option>
              </select>
              <small id="pcChartInfo" class="text-muted ms-2"></small>
            </div>
          </div>
          <canvas id="detectionsByPcChart" height="140"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@push('js')
<script>
  (function loadChartJs(cb){
      if (window.Chart) return cb();
      var s=document.createElement('script');
      s.src='https://cdn.jsdelivr.net/npm/chart.js';
      s.onload=cb; document.head.appendChild(s);
  })(function(){
      fetch("{{ route('detectionlogs.stats') }}")
          .then(r => r.json())
          .then(payload => {
              var ctx = document.getElementById('detectionsChart').getContext('2d');
              new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: payload.labels.map(l => l.slice(5)),
                      datasets: [{
                          label: 'Detections',
                          data: payload.data,
                          borderColor: '#dc3545',
                          backgroundColor: 'rgba(220,53,69,0.1)',
                          fill: true,
                          tension: 0.3
                      }]
                  },
                  options: {
                      responsive: true,
                      plugins: { legend: { display: false } },
                      scales: {
                          x: { display: true },
                          y: { display: true, beginAtZero: true }
                      }
                  }
              });
          }).catch(e => console.error('Chart load error', e));

// Expose function to window for debugging and fallback calls
window.renderPcBar = function renderPcBar(limit){
  var baseUrl = "{{ route('detectionlogs.stats_pc') }}";
  var finalUrl = baseUrl + '?days=7&limit=' + encodeURIComponent(limit || 10) + '&t=' + Date.now();
  console.debug('Loading PC bar chart:', finalUrl);
  fetch(finalUrl, { cache: 'no-store' })
            .then(r => r.json())
            .then(payload => {
                var ctx2 = document.getElementById('detectionsByPcChart').getContext('2d');
                if (window._pcBarChart) { window._pcBarChart.destroy(); }
                window._pcBarChart = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: payload.labels,
                        datasets: [{
                            label: 'Detections',
                            data: payload.data,
                            backgroundColor: '#0f64bf',
                        }]
                    },
                    options: {
                        responsive: true,
            animation: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { display: true, ticks: { autoSkip: false, maxRotation: 45, minRotation: 0 } },
                            y: { beginAtZero: true }
                        }
                    }
                });
                // Update helper info text
                var info = document.getElementById('pcChartInfo');
                if (info && payload.meta) {
                  var returned = payload.meta.returned || (payload.data ? payload.data.length : 0);
                  info.textContent = 'Showing top ' + returned + ' of ' + (payload.meta.totalDistinct || returned);
                }
            }).catch(e => console.error('PC chart load error', e));
      }
    // Use select's current value for initial render
    var limitEl = document.getElementById('pcChartLimit');
    var initial = 10;
    if (limitEl) {
      // initial value from DOM
      initial = parseInt(limitEl.value, 10) || initial;
      // primary listener
      limitEl.addEventListener('change', function(){
        var v = parseInt(this.value, 10) || initial;
        console.debug('pcChartLimit change ->', v);
        window.renderPcBar(v);
      });
      // inline onchange fallback (in case event binding timing issues occur)
      limitEl.setAttribute('onchange', 'window.renderPcBar(this.value)');
    }
    // initial render
    window.renderPcBar(initial);
  });
</script>
@endpush
@endsection
