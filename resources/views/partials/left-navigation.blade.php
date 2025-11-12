<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    
    @include('partials.left-nav-branding')

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="{{ url('/dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div>Dashboard</div>
            </a>
        </li>

        <!-- Exam Settings -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-layout"></i>
            <div>Exam Settings</div>
            </a>

            <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ url('add-exam') }}" class="menu-link">
                <div>Add Exam</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('list-exam') }}" class="menu-link">
                <div>Exam List / Set Current</div>
                </a>
            </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Preliminary [MCQ TYPE]</span>
        </li>
        <!-- Data Processing -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-folder-open"></i>
            <div>Data Processing</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('/config-data-line') }}" class="menu-link">
                    <div>DATA Line Configuration</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/upload-data-file') }}" class="menu-link">
                    <div>Upload DATA File</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/convert-data-file') }}" class="menu-link">
                    <div>Convert DATA File</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/upload-regi-file') }}" class="menu-link">
                    <div>Upload Regi File</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/generate-issue-status') }}" class="menu-link">
                    <div>Generate DATA Issues</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/issue-logs') }}" class="menu-link">
                    <div>Issue Logs</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/solve-data') }}" class="menu-link">
                    <div>Solve DATA</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/generate-hexcode') }}" class="menu-link">
                    <div>Hex Generation</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Result Processing -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cube-alt"></i>
            <div>Result Processing</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ url('/answer-key-posting') }}" class="menu-link">
                <div>Answer Key Posting</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/calculate-mark') }}" class="menu-link">
                <div>Mark Calculation</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/cut-mark-posting') }}" class="menu-link">
                <div>Cut Mark Posting</div>
                </a>
            </li>
            
            </ul>
        </li>
        <!-- Reports -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
            <div>Reports</div>
            </a>
            <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ url('/exam-status-report') }}" class="menu-link">
                <div>Current Exam Status</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/absent-list-report') }}" class="menu-link">
                <div>Absent List</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/eh-error-report') }}" class="menu-link">
                <div>E/H Error Report</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/eh-balance-report') }}" class="menu-link">
                <div>E/H Balance Report</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/answer-key-report') }}" class="menu-link">
                <div>Answer Key Report</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/score-frequency-report') }}" class="menu-link">
                <div>Score Frequency</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/print-result') }}" class="menu-link">
                <div>Result Printing</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ url('/export-result') }}" class="menu-link">
                <div>Export Result</div>
                </a>
            </li>
            </ul>
        </li>
        
        <!-- Configurations -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
        <li class="menu-item">
            <a href="{{ url('/master-configs') }}" target="_blank" class="menu-link">
            <i class="menu-icon tf-icons bx bx-save"></i>
            <div data-i18n="Support">Master Configurations</div>
            </a>
        </li>

        <!-- User Management -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">User Management</span></li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('add-user') }}" class="menu-link">
                        <div>Add New User</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('list-user') }}" class="menu-link">
                        <div>User List</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
<!-- / Menu -->