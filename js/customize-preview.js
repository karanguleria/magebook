!function(e){var o=e("#magbook-color-scheme-css"),t=wp.customize;o.length||(o=e("head").append('<style type="text/css" id="magbook-color-scheme-css" />').find("#magbook-color-scheme-css")),t("blogname",function(o){o.bind(function(o){e(".site-title a").text(o)})}),t("blogdescription",function(o){o.bind(function(o){e(".site-description").text(o)})}),t.bind("preview-ready",function(){t.preview.bind("update-color-scheme-css",function(e){o.html(e)})})}(jQuery);