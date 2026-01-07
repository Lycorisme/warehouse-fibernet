<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12 col-sm-12 text-center">
                Copyright © {{ date('Y') }} <a href="javascript:void(0)">{{ $web->web_footer == "" ? $web->web_nama : $web->web_footer }}</a>. All rights reserved.
            </div>
        </div>
    </div>
</footer>