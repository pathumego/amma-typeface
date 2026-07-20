$(document).ready(function() {
    performEffect($("div.opacity1:first"), 500);

    function performEffect($div, delay)
    {
        $div.fadeTo("slow", 0).fadeTo("slow", 0.9, function() {
            var $next = $div.nextAll("div.opacity1");
            if (!$next.length) {
                $next = $("div.opacity1");
            }
            performEffect($next.first().delay(delay), delay);
        });
    }
});