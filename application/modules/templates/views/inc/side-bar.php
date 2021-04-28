    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?php echo base_url(); ?>assets/files/logo.svg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url(); ?>assets/files/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $username; ?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
            <a href="<?php echo base_url('attendance'); ?>" class="nav-link active link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

        <!-- ATTENDANCE ============= -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Attendance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('persons-info'); ?>" class="nav-link link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Persons Information</p>
                </a>
              </li>

              <!--li class="nav-item">
                <a href="<?php //echo base_url('bank-details'); ?>" class="nav-link link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bank details</p>
                </a>
              </li -->
            </ul>
          </li>

        <!-- TRAINGS ============= -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Trainings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('acty'); ?>" class="nav-link link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activities</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('payments/payment_index'); ?>" class="nav-link link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Payments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('pymts'); ?>" class="nav-link link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Payments</p>
                </a>
              </li>
            </ul>
          </li>

        <!-- SYSTEM SETTINGS ============= -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>System Settings
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('system-settings'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Variables</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('public-holidays'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Holidays</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('regions'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Regions</p>
                    </a>
                  </li>
                  <li class="nav-item"> 
                    <a href="<?php echo base_url('districts'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Districts</p>
                    </a>
                  </li>
               
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    User Management
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url('user-groups'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>User Groups</p>
                    </a>
                  </li> 
                  <li class="nav-item">
                    <a href="<?php echo base_url('system-users'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Manage Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url('audit-trail'); ?>" class="nav-link link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>System Logs</p>
                    </a>
                  </li>
                </ul>
              </li>
              
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->