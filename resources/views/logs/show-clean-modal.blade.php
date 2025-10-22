<div class="modal fade" id="logCleanModal" tabindex="-1" aria-labelledby="logCleanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-fullscreen-lg-down" style="max-width:1200px;">
    <div class="modal-content" style="max-width:1200px;">
      <div class="modal-header">
          <div style="display:flex; flex-direction:column;">
            <h5 class="modal-title" style="margin:0;">Clean PC List</h5>
            <small class="text-muted">Aggregated PCs that reported no suspicious files</small>
          </div>
          <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
            <button class="btn btn-sm btn-light" id="refresh-clean-list" title="Refresh list"><i class="fas fa-sync-alt"></i></button>
            <a class="btn btn-sm btn-light" href="{{ route('detectionlogs.export_clean') }}" title="Export Excel (.xlsx)"><i class="fas fa-file-excel"></i></a>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="log-clean-table" class="table table-striped table-bordered table-sm" style="width:100%; table-layout:auto; white-space:nowrap;">
            <colgroup>
              <col style="width:28%" />
              <col style="width:18%" />
              <col style="width:18%" />
              <col style="width:18%" />
              <col style="width:18%" />
            </colgroup>
            <thead>
              <tr>
                <th class="text-center text-truncate" title="PC Name">PC Name</th>
                <th class="text-center text-truncate" title="User">User</th>
                <th class="text-center text-truncate" title="IP Address">IP Address</th>
                <th class="text-center text-truncate" title="MAC Address">MAC Address</th>
                <th class="text-center text-truncate" title="Last Clean At">Last Clean At</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
