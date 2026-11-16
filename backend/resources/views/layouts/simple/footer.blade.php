@switch(Route::currentRouteName())
    @case('admin.footer_dark')
        <footer class="footer footer-dark">
        @break
    
    @case('admin.footer_fixed')
        <footer class="footer footer-fix">
        @break

    @default
       <footer class="footer">
@endswitch
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0">Copyright <span class="year-update"> </span> © Leacent BookApp by Ao webtechtech</p>
                <p class="mb-0 small text-muted">If you are looking for real-life investment, entrepreneurship, and business management resources, you are looking for Leacent's Business Lab Books - and Movies - brought to you by Firstborn Publishing.</p>
            </div>
        </div>
    </div>
</footer>
