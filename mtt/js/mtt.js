
frame = $('#preview');
endpointsBase = 'mtt/api/endpoints/';
templatesDir = 'templates/'

// observe iframe resize
let resizeObserver = new ResizeObserver(() => {
    updateFrameSize();
});
resizeObserver.observe(frame[0]);




$(document).ready(function(){
    updateFrameSize();
    watchFileSelect();

});

function updateFrameSize(){
    let sizedisplay = $('#framesize');
    let width = frame.width();
    let height = frame.height();
    let str = width + " x " + height;
    sizedisplay.text(str);
}

function watchFileSelect(){
    // initial
    let initialFile = $("#fileselect option:selected").val();
    if(initialFile !=""){
        updatePreview(initialFile);
    }

    // event listener onchange
    $('#fileselect').change(function(){
        let newFile = this.value;
        updatePreview(newFile);
    });
}


function updatePreview(filename){
    frame.attr('src', templatesDir + filename);
}



