<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('admin.home')}}" class="nav-link">{{trans('app.home')}}</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">{{trans('app.support-contact')}}</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav {{ (strtolower(langDirection()) == 'rtl')? 'mr-auto-navbav': 'ml-auto' }} ">


        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ route('set-local', 'en') }}">
                {{ App\Models\Language::getlang(app()->getLocale())->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @foreach(getLangs() as $lang)
                <a href="{{ route('set-local', $lang->code) }}" class="dropdown-item">
                    @if(app()->getLocale() != $lang->code)
                    {{ ucfirst($lang->name) }}
                    @endif
                </a>
                @endforeach
            </div>
        </li>


        @if(strtolower(langDirection()) != 'rtl')
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> -->

        @endif

    </ul>
</nav>
<!-- /.navbar -->
