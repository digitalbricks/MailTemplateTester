
frame = $('#preview');
endpoints = 'mtt/api/endpoints/';

// observe iframe resize
let resizeObserver = new ResizeObserver(() => {
    updateFrameSize();
});
resizeObserver.observe(frame[0]);




$(document).ready(function(){
    updateFrameSize();
    updateFileSelect();

});

function updateFrameSize(){
    let sizedisplay = $('#framesize');
    let width = frame.width();
    let height = frame.height();
    let str = width + " x " + height;
    sizedisplay.text(str);
}

function updateFileSelect(){
    let field = $('#fileselect');

    $.getJSON( endpoints + "getfiles.php", function( data ) {
        var items = [];
        $.each( data, function( key, val ) {
            items.push( "<option value='" + val + "'>" + val + "</option>" );
        });
        if(data.length != 0){
            field.html(items.join( "" ))
        } else {
            UIkit.notification(
                'No .html files found in templates folder.',
                {
                    pos: 'top-right',
                    status: 'danger',
                    timeout: '10000'

                }
            );
        }

    });
}

