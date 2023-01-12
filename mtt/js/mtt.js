
frame = $('#preview');
lastmodifiedtimefield = $('#lastmodifiedtime');
endpointCheckChanges = 'mtt/api/endpoints/checkchanges.php';
endpointSendMail = 'mtt/api/endpoints/sendmail.php';
templatesDir = 'templates/'
pollintervall = $("#intervalselect option:selected").val();

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
    watchIntervalSelect();
    watchMailSend();

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

function watchIntervalSelect(){
    // event listener onchange
    $('#intervalselect').change(function(){
        pollintervall = this.value;
        console.info('Polling intervall changed to ' + this.value/1000+" seconds");
    });
}


function updatePreview(filename){
    frame.attr('src', templatesDir + filename);
}


function checkForChanges(){
    setSuccessStatus(false);
    let lastmodified_time = lastmodifiedtimefield.val();
    let filename = $("#fileselect option:selected").val();

    // if no template loaded (showing default page only)
    // we do nothing.
    if(lastmodified_time == 0){
        return;
    }

    $.post( endpointCheckChanges, { filename: filename, lastmodified_time: lastmodified_time }, function(data ) {
        let modified_time = data.modified_time;
        let modified = data.modified;
        if(modified){
            lastmodifiedtimefield.val(modified_time);
            updatePreview(filename + "?t="+ getTimestampInSeconds ());
            console.info(filename + ": Changes detected");
            setSuccessStatus(true);
        }
        //console.info(filename + ": NO changes detected");
    }).done(function() {
        setSuccessStatus(true);
    }).fail(function() {
        console.warn('An error occured during check for updates.')
        setSuccessStatus(false);
    });
}

function pollForChanges(){
    checkForChanges();
    window.Timer = setTimeout(pollForChanges, pollintervall);
}


function getTimestampInSeconds() {
    return Math.floor(Date.now() / 1000)
}

function setSuccessStatus(state = false){
    let stateindicator = $('#status');
    if(state){
        stateindicator.addClass('success');
        return;
    }
    stateindicator.removeClass('success');
}


function watchMailSend(){
    let form = $('#settingsform');
    form.submit(function(e) {
        e.preventDefault();
        let filename = $("#fileselect option:selected").val();
        $.post( endpointSendMail, { filename: filename }, function(data ) {
            let status = data.status;
            let error = data.error;
            if(status){
                UIkit.notification("<strong>Test mail sent</strong>", {status: 'success', pos: 'top-right'});
            } else{
                UIkit.notification("<strong>Test mail NOT sent</strong><br>" + error, {status: 'danger', pos: 'top-right'});
            }

        }).fail(function() {
            UIkit.notification("Endpoint not reached", {status: 'danger', pos: 'top-right'});
        });;
    });
}