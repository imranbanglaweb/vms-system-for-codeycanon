<!-- Master Data Management -->
@canany(['project-list', 'land-list', 'document-type-list'])
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database"></i>
        <p>
            Master Data
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('project-list')
        <li class="nav-item">
            <a href="{{ route('master.projects.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Projects</p>
            </a>
        </li>
        @endcan

        @can('land-list')
        <li class="nav-item">
            <a href="{{ route('master.lands.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lands</p>
            </a>
        </li>
        @endcan

        @can('document-type-list')
        <li class="nav-item">
            <a href="{{ route('master.document-types.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Document Types</p>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcanany

<!-- Documents Section -->
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-file-text"></i>
        <p>
            Documents
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('document-list')
        <li class="nav-item">
            <a href="{{ route('documents.index') }}" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Manage Documents</p>
            </a>
        </li>
        @endcan
        
        @can('document-history-view')
        <li class="nav-item">
            <a href="{{ route('document.history.index') }}" class="nav-link">
                <i class="fa fa-history nav-icon"></i>
                <p>Document History</p>
            </a>
        </li>
        @endcan
    </ul>
</li> 