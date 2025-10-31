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
            <a href="#" class="menu-link">
            <div>Add Exam</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Set Current Exam</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Exam List</div>
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
                <a href="#" class="menu-link">
                <div>DATA File Configurations</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div>Upload DATA Files</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div>Solve DATA</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div>Hex Generation</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="pages-account-settings-notifications.html" class="menu-link">
                <div>Hex Matching</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div>Bulk Status</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div>Issue Logs</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <div>Upload Regi File</div>
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
            <a href="#" class="menu-link">
            <div>Answer Key Posting</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Mark Calculation</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
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
            <a href="#" class="menu-link">
            <div>Current Exam Status</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Absent/Present List</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>E/H Balance Report</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Answer Key Report</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Score Frequency</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Result Printing</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div>Export Result</div>
            </a>
        </li>
        </ul>
    </li>
    
    <!-- Configurations -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
    <li class="menu-item">
        <a href="#" target="_blank" class="menu-link">
        <i class="menu-icon tf-icons bx bx-save"></i>
        <div data-i18n="Support">Master Configurations</div>
        </a>
    </li>
    </ul>
</aside>
<!-- / Menu -->