$(document).ready(function () {
    const $banner = $('#cookieBanner');
    if (!$banner.length) {
        return;
    }
    const consent = localStorage.getItem('cookie_consent');
    if (!consent) {
        $banner.removeClass('d-none');
    }
    $('#cookieAccept').on('click', function () {
        localStorage.setItem('cookie_consent', 'all');
        $banner.addClass('d-none');
        enableAnalytics();
    });
    $('#cookieReject').on('click', function () {
        localStorage.setItem('cookie_consent', 'necessary');
        $banner.addClass('d-none');
    });
    function enableAnalytics() {
        const consent = localStorage.getItem('cookie_consent');
        if (consent !== 'all') {
            return;
        }
        console.log('Analytics enabled');
    }
});