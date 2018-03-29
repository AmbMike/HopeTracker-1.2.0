<section class="intervention-advice" id="accordion-pg-v1">
    <div class="title-box">having a intervention</div>
    <div class="quote-box">
        <p>what should an intervention meeting be like?</p>
        <button class="quote-btn"></button>
        <div class="panel">
            <p class="quote">
                A welcoming group of people in similar situations will share there experiences and support with any concerns you may have.
            </p>
        </div>
    </div>
    <hr>
    <div class="quote-box">
        <p>what should i say?</p>
        <button class="quote-btn"></button>
        <div class="panel">
            <p class="quote">
                A welcoming group of people in similar situations will share there experiences and support with any concerns you may have.
            </p>
        </div>
    </div>
    <hr>
    <div class="quote-box">
        <p>how do i over come their excuses?</p>
        <button class="quote-btn"></button>
        <div class="panel">
            <p class="quote">
                A welcoming group of people in similar situations will share there experiences and support with any concerns you may have.
            </p>
        </div>
    </div>
    <hr>
    <div class="quote-box">
        <p>what should i do if the situation is dire?</p>
        <button class="quote-btn"></button>
        <div class="panel">
            <p class="quote">
                A welcoming group of people in similar situations will share there experiences and support with any concerns you may have.
            </p>
        </div>
    </div>
    <hr>
    <div class="quote-box">
        <p>how is the final meeting different?</p>
        <button class="quote-btn"></button>
        <div class="panel">
            <p class="quote">
                A welcoming group of people in similar situations will share there experiences and support with any concerns you may have.
            </p>
        </div>
    </div>
    <hr>
    <div class="next-btn"><i class="fa fa-angle-down" aria-hidden="true"></i>next</div>

    <script>
        var accordion = document.getElementsByClassName("quote-btn");
        var i;

        for (i = 0; i < accordion.length; i++) {
            accordion[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
</section>