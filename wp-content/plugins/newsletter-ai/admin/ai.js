jQuery(function ($) {
    jQuery('#tnpc-subject-ai-button').on('click', function (ev) {
        ev.preventDefault();
        $subject = $('#options-subject-subject');
        if ($subject.val().length < 20) {
            alert('Some more words are required to generate ideas for youre subject');
            console.log('Empty subject');
        } else {
            jQuery('#tnpc-subject-ai-content').html('<h3>Our assistant is creating for you...</h3><div class="tnp-ellipsis"><div></div><div></div><div></div><div></div></div>');
            jQuery('#tnpc-subject-ai').modal({
                clickClose: false,
                fadeDuration: 500
            });
            $.post(ajaxurl, {
                subject: $subject.val(),
                action: 'newsletter_ai_subjects',
                _ajax_nonce: tnp_ai_nonce
            }).done(function (data) {
                console.log(data);
                $('#tnpc-subject-ai-content').html(data);
            }).fail(function () {
                $.modal.close();
                console.log('Failed');
                alert('Failed to contact the Newsletter Assistant, check to have your license set on the Newsletter main settings');

            });
        }

    });
});

var tnp_generating = false;
function tnp_ai_generate(button) {
    if (tnp_generating) return;
    tnp_generating = true;
    button.value = 'Wait please (it takes many seconds)';
    button.disabled = true;
    aprompt = document.getElementById('options-prompt').value;
    console.log(aprompt);
    jQuery.post(ajaxurl, {
        prompt: aprompt,
        action: 'newsletter_ai_generate',
        _ajax_nonce: tnp_ai_nonce
    }).done(function (data) {
        console.log(data);
        document.getElementById('options-html').value = data;
        tinymce.activeEditor.load();
        button.value = 'Go';
        tnp_generating = false;
        button.disabled = false;
        //tinymce.triggerU
        //callback(data);
    }).fail(function () {
        console.log('Failed');
        alert('Failed to contact the Newsletter Assistant, check to have your license set on the Newsletter main settings');
        button.value = 'Go';
        button.disabled = false;
        tnp_generating = false;
    });
}