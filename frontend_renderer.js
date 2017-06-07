function register_template(name, url) {
    if (Handlebars === undefined) {
        console.log("Handlebars not loaded yet");
    }
    if (Handlebars.template[name] === undefined) {
        $.get({
            url: url,
            success: function (data) {
                Handlebars.template[name] = Handlebars.compile(data);
            },
            error: function (data) {
                console.log("Error requesting Template: "+ url);
            }
        });
    }
}
