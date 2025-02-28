"use strict";
function _classCallCheck(e, n) {
    if (!(e instanceof n))
        throw new TypeError("Cannot call a class as a function");
}
function _defineProperties(e, n) {
    for (var t = 0; t < n.length; t++) {
        var o = n[t];
        (o.enumerable = o.enumerable || !1),
            (o.configurable = !0),
            "value" in o && (o.writable = !0),
            Object.defineProperty(e, o.key, o);
    }
}
function _createClass(e, n, t) {
    return (
        n && _defineProperties(e.prototype, n), t && _defineProperties(e, t), e
    );
}
$("[data-countdown]").each(function () {
    var e = $(this),
        n = $(this).data("countdown");
    e.countdown(n, function (e) {
        $(this).html(
            e.strftime(
                '<div class="coming-box">%D <span>Days</span></div> <div class="coming-box">%H <span>Hours</span></div> <div class="coming-box">%M <span>Minutes</span></div> <div class="coming-box">%S <span>Seconds</span></div> '
            )
        );
    });
});
var Countdown = (function () {
    function e() {
        _classCallCheck(this, e);
    }
    return (
        _createClass(e, [
            {
                key: "initCountDown",
                value: function () {
                    var a, s;
                    document.getElementById("days") &&
                        ((a = new Date("March 1, 2028 16:37:52").getTime()),
                        (s = setInterval(function () {
                            var e = new Date().getTime(),
                                n = a - e,
                                t = Math.floor(n / 864e5),
                                o = Math.floor((n % 864e5) / 36e5),
                                i = Math.floor((n % 36e5) / 6e4),
                                e = Math.floor((n % 6e4) / 1e3);
                            (document.getElementById("days").innerHTML = t),
                                (document.getElementById("hours").innerHTML =
                                    o),
                                (document.getElementById("minutes").innerHTML =
                                    i),
                                (document.getElementById("seconds").innerHTML =
                                    e),
                                n < 0 &&
                                    (clearInterval(s),
                                    (document.getElementById("days").innerHTML =
                                        ""),
                                    (document.getElementById(
                                        "hours"
                                    ).innerHTML = ""),
                                    (document.getElementById(
                                        "minutes"
                                    ).innerHTML = ""),
                                    (document.getElementById(
                                        "seconds"
                                    ).innerHTML = ""),
                                    (document.getElementById("end").innerHTML =
                                        "00:00:00:00"));
                        }, 1e3)));
                },
            },
            {
                key: "init",
                value: function () {
                    this.initCountDown();
                },
            },
        ]),
        e
    );
})();
new Countdown().init();
