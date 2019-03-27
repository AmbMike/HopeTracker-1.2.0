<?php
    include_once( CLASSES . 'URL.php' );
    $URL = new URL();
?>
<div class="insurance-form-container">
	<div id="insurance-form">
		<div data-after-submission-text="Successfully Sent!" data-element="heading" class="insurance-check">
			Insurance Checker
		</div>
        <div data-form-insurance="close" class="close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="success-msg-box">
           <p>A specialist will call your insurance company directly, skipping the generic customer service. You'll get a simplified outline of options based on your loved one's specific:</p>
            <ul>
                <li>Insurance policy rules</li>
                <li>Insurance usage to-date</li>
                <li>Specific treatment codes</li>
            </ul>
            <p><strong>Hang tight! Within 24 hours, you'll get a call back with costs and next step.</strong></p>
            <a href="tel:<?php echo MAIN_PHONE ?>" class="phone"><?php echo \Page_Attr\Format::phone(MAIN_PHONE) ?></a>
            <span class="live-agent">Call if you want answers now.</span>
        </div>
        <div class="form-elements">
            <div class="content">
                <p>
                    Find out what will be covered.<br>
                    Or, save time and <strong>just give us a call.</strong><br>
                    We'll fill it out for you and explain everything.
                </p>
                <a href="tel:<?php echo MAIN_PHONE ?>" class="phone"><?php echo \Page_Attr\Format::phone(MAIN_PHONE) ?></a>

                <span class="live-agent"><strong>2</strong> specialists available now</span>
            </div>
            <ul id="steps">
                <li class="step one">
                    Step 1
                </li>
                <li class="step two">
                    <span class="text">Step 2</span>
                </li>
            </ul>
            <form class="form" id="insuranceForm">
                <div class="form-part">
                    <div class="form-group">
                        <label for="phone">Your Phone:</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="lovedOneName">Loved One's Name:</label>
                        <input type="text" name="lovedOneName" class="form-control" id="lovedOneName">
                    </div>
                    <div class="form-group">
                        <label for="lovedOneDOB">Loved One's Date of Birth:</label>
                        <input type="text" name="lovedOneDOB" placeholder="xx/xx/xxxx" class="form-control" id="lovedOneDOB">
                    </div>
                    <div class="form-group">
                        <label for="lovedOneZip">Loved One's Zip:</label>
                        <input type="text" name="lovedOneZip" class="form-control" id="lovedOneZip">
                    </div>
                </div>
                <div class="form-part">
                    <div class="form-group">
                        <label for="lovedOneInsurance">Loved One's Insurance:</label>
                        <input type="text" name="lovedOneInsurance" class="form-control" id="lovedOneInsurance">
                    </div>
                    <div class="form-group">
                        <label for="lovedOneInsuranceId">Loved One's Insurance ID number:</label>
                        <input type="text" name="lovedOneInsuranceId" class="form-control" id="lovedOneInsuranceId">
                    </div>
                    <div class="form-group">
                        <label for="policyHolderName">Policy Holder Name:</label>
                        <input type="text" name="policyHolderName" class="form-control" id="policyHolderName">
                    </div>
                    <div class="form-group">
                        <label for="drugOfChoice">Loved One's Drug of Choice</label>
                        <input type="text" name="drugOfChoice" class="form-control" id="drugOfChoice">
                    </div>
                    <input type="hidden" name="submitted_url" value="<?php echo $URL->current_url(); ?>">
                </div>
                <button type="button" data-part="1" id="form-btn" data-step-two-text="Submit" class="btn btn-default btn-block form-btn">Next</button>
            </form>
        </div>
	</div>
</div>
