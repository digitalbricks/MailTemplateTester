
frame = $('#preview');
lastmodifiedtimefield = $('#lastmodifiedtime');
endpoint = 'mtt/api/endpoints/checkchanges.php';
templatesDir = 'templates/'
pollintervall = 5000;

// observe iframe resize
let resizeObserver = new ResizeObserver(() => {
    updateFrameSize();
});
resizeObserver.observe(frame[0]);




$(document).ready(function(){
    updateFrameSize();
    watchFileSelect();
    checkForChanges();
    pollForChanges();

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


function checkForChanges(){
    let lastmodified_time = lastmodifiedtimefield.val();
    let filename = $("#fileselect option:selected").val();

    // if no template loaded (showing default page only)
    // we do nothing.
    if(lastmodified_time == 0){
        return;
    }

    $.post( endpoint, { filename: filename, lastmodified_time: lastmodified_time }, function( data ) {
        let modified_time = data.modified_time;
        let modified = data.modified;
        if(modified){
            lastmodifiedtimefield.val(modified_time);
            updatePreview(filename + "?t="+ getTimestampInSeconds ());
            console.log(filename + ": Changes detected");
        }
        console.log(filename + ": NO changes detected");
    });
}

function pollForChanges(){
    checkForChanges();
    setTimeout(pollForChanges, pollintervall);
}


function getTimestampInSeconds() {
    return Math.floor(Date.now() / 1000)
}

