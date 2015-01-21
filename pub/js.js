(function() {

    $(document).ready(function() {
        $.nette.ext('init').linkSelector = 'a[data-zax-ajax]';
        $.nette.init();
    });

})();