<h3><?php echo $heading_title; ?></h3>

<form onsubmit="event.preventDefault();" class="form-horizontal">

    <div class="form-group row">
        <label class="col-sm-2 control-label" for="input-email">
            <?php echo $text_email; ?>
        </label>
        <div class="col-sm-10">
            <input type="email" name="email" value="" placeholder="<?php echo $text_placeholder; ?>" id="inputSubscriptionEmail" class="form-control" />
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-12">
            <button id="subscriptionBtn" class="btn-block btn btn-default"><?php echo $btn_subscription; ?></button>
        </div>
    </div>

</form>

<div id="subscriptionOutput"></div>

<script>
    $('#subscriptionBtn').on('click', function() {
        $.ajax({

            url: 'index.php?route=extension/module/custom_subscription/addEmail',
            type: 'post',
            data: {
                email: $('#inputSubscriptionEmail').val()
            },
            dataType: 'json',

            success: function(json) {

                if (json['error']) {
                    $('#subscriptionOutput').html('<div class="alert alert-danger" role="alert">'+ json["error"] + '</div>');
                }

                if (json['success']) {
                    $('#subscriptionOutput').html('<div class="alert alert-success" role="alert">'+ json["success"] + '</div>');
                }
            }

        });
    });
</script>