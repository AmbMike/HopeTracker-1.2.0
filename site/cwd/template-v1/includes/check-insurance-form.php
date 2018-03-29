<div class="insurance-form-container">
    <div id="check-insurance-form">
        <div data-after-submission-text="Successfully Sent!" data-element="heading" class="insurance-check green-bg">
            <i class="fa fa-angle-left" aria-hidden="true"></i>recovery is possible
        </div>
        <div data-form-insurance="close" class="close">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
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
                    Or save time and <strong>just give us a call.</strong><br>
                    We'll fill it out for you and explain everything.
                </p>
                <a href="tel:<?php echo MAIN_PHONE ?>" class="phone"><?php echo \Page_Attr\Format::phone(MAIN_PHONE) ?></a>

                <span class="live-agent"><strong>2</strong> specialists available now</span>
            </div>
            <!--
            <ul id="steps">
                <li class="step one">
                    Step 1
                </li>
                <li class="step two">
                    <span class="text">Step 2</span>
                </li>
            </ul>
            -->
            <form class="form" id="insuranceForm">
                <div class="form-part">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your User Name" class="form-control" id="user-name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Your Phone" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="forWho" class="title">Are you helping yourself or a loved one?</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="myself" id="myself" value="Myself">
                        <label for="forWho" class="centerSpace">Myself</label>
                        <input type="checkbox" name="lovedOne" id="lovedOne" value="lovedOne">
                        <label for="forWho">A loved one</label>
                    </div>
                    <div class="form-group">
                        <label for="checkFor" class="title">Do you have health insurance?</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="yes" id="yes" value="yes">
                        <label for="checkFor" class="centerSpace">Yes</label>
                        <input type="checkbox" name="no" id="no" value="no">
                        <label for="checkFor">No</label>
                    </div>
                    <div class="form-group">
                        <textarea class=""></textarea>
                    </div>
                </div>
                <!--
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
                    <input type="hidden" name="submitted_url">
                </div>
                -->
                <button type="button" data-part="1" id="form-btn" data-step-two-text="Submit" class="btn btn-default btn-block form-btn">Start Healing</button>
            </form>
        </div>

    </div>
</div>