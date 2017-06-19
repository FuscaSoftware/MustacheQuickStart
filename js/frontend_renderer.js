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
function register_partial(name, url) {
    if (Handlebars === undefined) {
        console.log("Handlebars not loaded yet");
    }
    $.get({
        url: url,
        success: function (data) {
            Handlebars.registerPartial(name, data);
        },
        error: function (data) {
            console.log("Error requesting Template: "+ url);
        }
    });
}
function details(index) {
    var html, index2, data;
    index2 = index + 1;
    data = {data: data_json[index]};
    html = Handlebars.template.details(data);
    // html = data.birthday;
    $('table tr:nth-child('+index2+') td.details').html(html);
}