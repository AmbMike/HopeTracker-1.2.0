/*
 * Copyright (c) 2017.
 */

if($('[data-questions-parent="true"]').length > 0){
    $(document).ready(function () {
        'use strict';
        forumQuestions();

        askQuestion();

        //answerQuestion('#forum-answer-question-form');
        answerQuestionMain('#forum-answer-question-form-1');

        questionFilters();

        forumJumpTo();

    });
}

/** User Profile Question/Answer filters */
function forumQuestions(){
    'use strict';

    var pageID = '#new-forum';
    var pageParent = '[data-questions-parent="true"]';
    var profileParent = pageParent +  ' .user-title-box';
    var profileQuestions = profileParent +  ' .questions';
    var profileAnswers = profileParent +  ' .answers';
    var profileFollowing = profileParent +  ' .following';
    var answerBox = pageParent + ' .answer-box';
    var userId = $(pageParent).data('user-id');

    /**  The questions body div ID */
    var questionBodyId = pageID + ' #categories';

    /** Categories */
    var categoryBox = pageParent + ' .category';

    /** Profile Section Actions */

    /** When clicked the "Question" link located in the profile section */
    $(profileQuestions).on('click', function(){
        var $this = $(this);

        if(!$this.hasClass('on')){
            showUserQuestionsCategories();

            /** Hide subcategories that the user does not have a question in. */
            $(categoryBox + ' [data-users-post-subcategory="No"').slideUp(600);

            $(answerBox + '[data-users-question="No"]').slideUp(600);

        }else{
            showAllQuestionsCategories();

            /** Show all subcategories. */
            $(categoryBox + ' [data-users-post-subcategory="No"').slideDown(600);

            $(answerBox + '[data-users-question="No"]').slideDown(600);
        }

        function showUserQuestionsCategories() {

            /** Hide other profile filters */
            $this.parent().find('span').add($this.parent().find('i')).fadeOut(300,function () {
                $this.find('[data-filter-text]').text("Unfilter").css({'text-decoration' : 'underline'});
                $this.add($this.find('span')).fadeIn(400);
            });

            $this.addClass('on');
            $(categoryBox + '[data-user-post-category="No"').slideUp(600);
        }
        function showAllQuestionsCategories() {

            $this.add($this.find('span')).fadeOut(300,function () {
                $this.find('[data-filter-text]').text('Questions').css({'text-decoration' : 'none'});

                $this.parent().find('span').add($this.parent().find('i')).show();
                $this.parent().fadeIn(200);
            });

            $this.removeClass('on');
            $(categoryBox + '[data-user-post-category="No"').slideDown(600);
        }

    });
    $(profileAnswers).on('click', function(){
        var $this = $(this);

        /** Hide all questions that the user did not submit an answer to. */
        if(!$this.hasClass('on')){
            showUserAnsweredCategories();

        }else{
            showAllAnsweredCategories();
        }

        function showUserAnsweredCategories(){
            /** Add text and css to the clicked filter */


            /** Hide other profile filters */
            $this.parent().find('span').add($this.parent().find('i')).add('[data-users-answered="No"]').fadeOut(300,function () {
                $this.find('[data-filter-text]').text("Unfilter").css({'text-decoration' : 'underline'});
                $this.add($this.find('span')).fadeIn(400);
            });

            $this.addClass('on');
            $(pageID + ' [data-user-answered-category="No"').slideUp(600);
        }
        function showAllAnsweredCategories() {
            $this.add($this.find('span')).fadeOut(300,function () {
                $this.find('[data-filter-text]').text('Answers').css({'text-decoration' : 'none'});

                $this.parent().find('span').add($this.parent().find('i')).show();
                $this.parent().add('[data-users-answered="No"]').fadeIn(200);
            });
            $this.removeClass('on');
            $(pageID + ' [data-user-answered-category="No"').slideDown(600);
        }
    });
    $(profileFollowing).on('click', function(){
        var $this = $(this);

        /** Hide all questions that the user did not submit an answer to. */
        if(!$this.hasClass('on')){
            showFollowedPost();

        }else{
            showAllFollowedPost();
        }

        function showFollowedPost(){

            /** Hide other profile filters */
            $this.parent().find('span').add($this.parent().find('i')).fadeOut(300,function () {
                $this.find('[data-filter-text]').text("Unfilter").css({'text-decoration' : 'underline'});
                $this.add($this.find('span')).fadeIn(400);
            });

            $this.addClass('on');
            $(pageID + ' [data-followed-post-category="No"').add(pageID + ' [data-followed-post="No"]').add(pageID + ' [data-followed-post-subcategory="No"]').slideUp(600);
        }
        function showAllFollowedPost() {
            $this.add($this.find('span')).fadeOut(300,function () {
                $this.find('[data-filter-text]').text('Answers').css({'text-decoration' : 'none'});

                $this.parent().find('span').add($this.parent().find('i')).show();
                $this.parent().add('[data-followed-post-subcategory="No"]').fadeIn(200);
            });
            $this.removeClass('on');
            $(pageID + ' [data-followed-post-category="No"').add(pageID + ' [data-followed-post-subcategory="No"]').add(pageID + ' [data-followed-post="No"]').slideDown(600);
        }
    });
}
function askQuestion() {
    'use strict';

    /** Parent Ids */
    var modalId = '#ask-question-modal';
    var formId =  '#forum-ask-question-form';

    /* Content to be displayed before form is successfully submitted. */
    var preFormContent = modalId + ' .pre-form-content';

    /** The form success message box */
    var successBox = modalId + ' .success-box';

    /** Form object */
    var form = {
      id : formId,
        categories : formId + ' .category-form',
        categorySelect : formId + ' .category-form .select-styled',
        categoryOptions : formId + ' .category-form .select-options li',
        subcategories : formId + ' .subcategory',
        subcategorySelect : formId + ' .subcategory .select-styled',
        subcategoryOption : formId + ' .subcategory .select-options',
        subcategoryOptions : formId + ' .subcategory .select-options li',
        question : formId + ' #question',
        description : formId + ' #description'
    };

    /** Remove First Select From List */
    $(form.id + ' .select-options li').eq(0).remove();

    /** Onchange Categories */
    $(form.categoryOptions).on('click',function () {
        var $this = $(this);
        var category = $this.text();

        $(form.subcategoryOptions).remove();

        $.post(RELATIVE_PATH + '/config/processing.php', {form : 'Get Subcategory List', category : category, cache :  false}, function (response) {

            /** Initialize Sub-topic options */
            $(form.subcategorySelect).text('Select Sub-topic');

            $.each(response,function (index, value) {
                var subcategory = value.sub_category;
                $(form.subcategoryOption).append('<li rel="'+subcategory +'">'+subcategory +'</li>');
            });

        },'json');


    });
    /** Onchange Subcategories */
    $('body').on('click',form.subcategoryOptions,function () {
        var $this = $(this);

        $(form.subcategorySelect).text($this.text());
    });
    $(form.id).on('submit',function (e) {
        e.preventDefault();

        var errors = [];
        /** Array of values to check if the user has selected a category or subcategory. */
        var checkArray = ['Select Topic', '--', 'Select Sub-topic'];

        /** Check if user selected a subcategory */
        if($.inArray($(form.categorySelect).text(),checkArray) !== -1){
            errorFunc(form.categorySelect,'No Category');
        }
        /** Check if user selected a subcategory */
        if($.inArray($(form.subcategorySelect).text(),checkArray) !== -1){
            errorFunc(form.subcategorySelect,'No Subcategory');
        }

        /** Check if user entered a questions */
        if($(form.question).val() === ''){
            errorFunc(form.question,'Empty question');
        }

        /** Check if user entered a description */
        if($(form.description).val() === ''){
            errorFunc(form.description,'Empty description');

        }

        if(errors.length > 0){
            // Errors present
        }else{
            var ajaxData = {
                form : 'Ask Question Forum',
                data : {
                    category : $(form.categorySelect).text(),
                    subcategory : $(form.subcategorySelect).text(),
                    question : $(form.id + ' [name="question"]').val(),
                    description : $(form.id + ' [name="description"]').val(),
                },
                cache :  false

            };

           $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
               console.log(response);

               /** get and set the question count. */
               var questionCount =  $('[data-users-count="question"]').val();
               questionCount++;
               var questionCountCountUp =  questionCount;
               
               /** updated question profile value */
               $('[data-users-count="question"]').val(questionCountCountUp).text(questionCountCountUp);

               updatedSubcategoryQuestionCount();

               if(response.status === 'Success'){
                   $(preFormContent).slideUp(300,function () {
                       $(successBox).slideDown(300);
                   });
                   $(preFormContent).addClass('off');

                   $('#category-fill-box').load(location.href + " #categories");
                   $(form.id)[0].reset();
                   //$(modalId).modal('hide');

               }
           },'json');
        }

       /** Clear form if user close modal after the form was submitted. */

        function errorFunc(selector,errorMsg){
            errors.push(errorMsg);
            $(selector).css({'background': 'pink'});
            setTimeout(function () {
                $(selector).removeAttr('style');
            },3000);
        }

    });
}
function questionFilters() {
    'use strict';

    var pageId = '[data-questions-parent="true"]';
    var category = pageId +  ' .category';
    var subcategory = category +  ' .subcategory';
    var topFilters = subcategory +  ' [data-top-filter="container"] li';


    var profileFilters = pageId + ' .user-count-container > span';

    $(topFilters).on('click', function () {
        var $thisFilter = $(this);

        var questionsContainer = $thisFilter.parent().parent().find('[data-questions="container"]');

        /** Json object for the clicked filters. */
        var jsonObject = {
            category : $thisFilter.closest('.category').data('category'),
            subcategory : $thisFilter.closest('.subcategory').data('subcategory'),
            cache :  false
        };
        var ajaxFile;

        $thisFilter.siblings().removeClass('active');
        $thisFilter.addClass('active');

        switch ($thisFilter.data('filter')){
            case 'most recent':
                ajaxFile = 'getMostRecentQuestions';
                break;
            case 'top question':
                ajaxFile = 'getTopQuestions';
                break;
            case 'unanswered':
                ajaxFile = 'getBottomQuestions';
                break;
            default:
        }

        $.get(RELATIVE_PATH +'/ajax-loads/forum/' + ajaxFile +'.php', jsonObject, function (response) {

            /** File the area with the new questions */
            questionsContainer.html(response);

            /** Reset the answer section once the new question load. */
            answerQuestion('#forum-answer-question-form');

            /** Reset profile filters if the are set */
            $(profileFilters).each(function () {

                if($(profileFilters).hasClass('on')){
                    var $this = $(this);
                    $('[data-users-question="No"]').css({'display' : 'none'});
                }

            });


            /** Run human time */
            $('time.human-time').timeago();
        });

    });
}
function answerQuestion(formIdVar) {
    'use strict';

    /** Parent Ids */
    var pageParent = '[data-questions-parent="true"]';
    var modalId = '#answer-question-modal';
    var formId =  formIdVar;

    /* Content to be displayed before form is successfully submitted. */
    var preFormContent = modalId + ' .pre-form-content';

    /** The form success message box */
    var successBox = modalId + ' .success-box';

    /** Answer box where the user click to  ask a question. */
    var ShowAnswerBtn = pageParent + ' [data-show-answers-btn]';

    /**  Area to add the question to in the modal when the user clicks to answer question*/
    var questionOutForm = pageParent + ' [data-question-out="text"]';

    /**  Answers Container*/
    var AnswerContainer = pageParent + ' [data-answers="container"]';

    /**  Answers Container*/
    var AnswerQuestionBtn = pageParent + ' [data-answers="question"]';


    /** Form object */
    var form = {
        id : formId,
        question : formId + ' #question',
        answer : formId + ' #answer'
    };


    $('body').on('click',ShowAnswerBtn,function () {
        var $this = $(this);
        /** Toggle Answer Container */
        $this.closest('[data-question-id]').find('[data-answers="container"]').stop().slideToggle(400);
    });

    /** Answer Pagination */

    var answerPaginationBox = '[data-answer-pagination="box-forum"]';

    /** Answer pagination button */
    var answerPaginationBtn = pageParent + ' ' + answerPaginationBox + ' [data-pagination-number]';

    $('body').on('click',answerPaginationBtn, function () {
        var $this = $(this);

        /** Process the clicked pagination */
        if(!$this.hasClass('active')){


            /** the id for the question associated with the answers. */
            var questionId = $this.parent().data('question-id');

            /** The limit of answers to show. */
            var paginationLimit = $this.parent().data('question-pagination-limit');

            /** The number value for the pagination button clicked. */
            var paginationNumber = $this.data('pagination-number');

            /** The Container that hold all the tables. */
            var answerTables = $this.closest('[data-answers="container"]').find('[data-answer="tables"]');

            var ajaxData = {
                form : 'Forum Answer Pagination',
                data : {
                    questionId : questionId,
                    paginationNumber : paginationNumber,
                    paginationLimit : paginationLimit
                },
                cache :  false
            };

            /** switch active class around */
            $(answerPaginationBtn).removeClass('active');
            $this.addClass('active');

            /** get the pagination data */
            $.get(RELATIVE_PATH +'/ajax-loads/forum/getAnswers.php',ajaxData,function (response) {

                console.log(response);
                answerTables.html(response);
            });

        }

    });

    /** Pop Modal and send question to it */
    $('body').on('click',AnswerQuestionBtn,function () {
        var  $this = $(this);

        var $thisQuestionType = $this.data('answer-page');

        var thisQuestion;

        if($thisQuestionType === 'main-question'){
            thisQuestion = $this.parent().parent().parent().find('[data-question="text"]').text();
        }
        if($thisQuestionType === 'single-question'){
            thisQuestion = $this.closest('#post-single').find('[data-question="question"]').text();
        }

        /** send the question to the answer form */
        $(questionOutForm).text(thisQuestion);

        /** Send the question post id to the form data attribute */
        var thisQuestionId = $this.data('question-id');

        $(form.id).attr('date-question-id',thisQuestionId);
    });

    /** Process the "Answer a question" form. */
    $(form.id).on('submit',function (e) {
        e.preventDefault();

        /** The question id that the form is submitting the answer for */
        var forumQuestionId = $(this).attr('date-question-id');

        var answerBoxIdData = '#question-answer-box-data-' + forumQuestionId;
        var answerBoxId = '#question-answer-box-' + forumQuestionId;
        var errors = [];

        /** Check if user entered a description */
        if($(form.answer).val() === ''){
            errorFunc(form.answer,'Empty answer');
        }

        if(errors.length > 0){
            console.log('Error validating the form');
        }else{


            var ajaxData = {
                form : 'Answer Question Forum',
                data : {
                    question_id : $(form.id).attr('date-question-id'),
                    answer : $(form.id + ' [name="answer"]').val()
                },
                cache :  false

            };
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
                console.log(response);
                /** get and set the answers count. */
                var answerCount =  $('[data-users-count="answer"]').val();
                answerCount++;
                var answerCountUp =  answerCount;


                var answerCountSubcategory =  questionAnswerCountData.val();
                answerCountSubcategory++;
                var answerCountUpSubcategory =  answerCountSubcategory;


                if(response.status === 'Success'){
                    $(preFormContent).slideUp(300,function () {
                        $(successBox).slideDown(300);
                    });
                    $(preFormContent).addClass('off');

                    /** Updated question areas */
                    $(answerBoxId).load(location.href + "  " + answerBoxIdData);

                    /** updated question profile value */
                    $('[data-users-count="answer"]').val(answerCountUp).text(answerCountUp);

                    /** updated question subcategory answer value */
                    questionAnswerCountData.val(answerCountUpSubcategory).text(answerCountUpSubcategory);

                    $('#answerOuter').load(location.href + ' #answerInner');
                   /* $(successBox).slideUp(300,function () {
                        $(preFormContent).removeClass('off').slideDown(500);
                        $(form.id)[0].reset();
                        $(modalId).modal('hide');
                    });*/

                }
            },'json');
        }

        /** Clear form if user close modal after the form was submitted. */
        $(modalId).on('hidden.bs.modal', function () {
            if($(preFormContent).hasClass('off')){
                $(successBox).slideUp(300,function () {
                    $(preFormContent).removeClass('off').slideDown(500);
                    $(form.id)[0].reset();
                });
            }
        });

        function errorFunc(selector,errorMsg){
            errors.push(errorMsg);
            $(selector).css({'background': 'pink'});
            setTimeout(function () {
                $(selector).removeAttr('style');
            },3000);
        }

    });

}
function answerQuestionMain(formIdVar) {
    'use strict';

    /** Parent Ids */
    var pageParent = '[data-questions-parent="true"]';
    var formId =  formIdVar;

    /* Content to be displayed before form is successfully submitted. */
    var preFormContent =  ' .pre-form-content';

    /** The form success message box */
    var successBox = ' .success-box';



    /** Form object */
    var form = {
        id : formId,
        question : formId + ' #question',
        answer : formId + ' [name="answer"]'
    };


    /** Process the "Answer a question" form. */
    $(form.id).on('submit',function (e) {
        e.preventDefault();

        /** The question id that the form is submitting the answer for */
        var forumQuestionId = $(this).attr('date-question-id');

        var answerBoxIdData = '#question-answer-box-data-' + forumQuestionId;
        var answerBoxId = '#question-answer-box-' + forumQuestionId;
        var errors = [];

        /** Check if user entered a description */
        if($(form.answer).val() === ''){
            errorFunc(form.answer,'Empty answer');
        }

        if(errors.length > 0){
            console.log('Error validating the form');
        }else{


            var ajaxData = {
                form : 'Answer Question Forum',
                data : {
                    question_id : $(form.id).attr('date-question-id'),
                    answer : $(form.id + ' [name="answer"]').val()
                },
                cache :  false

            };
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
                console.log(response);

                if(response.status === 'Success'){
                    $(preFormContent).slideUp(300,function () {
                        $(successBox).slideDown(300);

                        $('#answerOuter').load(document.URL+  ' #answerInner');
                    });
                }
            },'json');
        }
        function errorFunc(selector,errorMsg){
            errors.push(errorMsg);
            $(selector).css({'background': 'pink'});
            setTimeout(function () {
                $(selector).removeAttr('style').css({'color' : '#555555'});
            },3000);
        }

    });

}

function updatedSubcategoryQuestionCount() {
    'use strict';

    var questionCount = '.questions-count';

    $(questionCount).each(function () {
        var $this = $(this);

        /** The value of the number of questions */
        var $thisValue = $this.closest('.panel').find('[data-question-body="true"]').length;

        $this.val($thisValue).text($thisValue);
    });
}

function forumJumpTo() {

    /** Functions for url param as a category */
    if($('[data-page-jump-value]').length > 0){

        var jumpToValue =   $('[data-page-jump-value]').data('page-jump-value'); console.log(jumpToValue);
        $('html,body').animate({scrollTop: $('[data-page-jump-to-href="'+jumpToValue+'"]').offset().top},'slow');
    }


    /** Functions for url param as a subcategory */
    if($('[data-page-jump-value-subcategory]').length > 0){

        var jumpToValue =   $('[data-page-jump-value-subcategory]').data('page-jump-value-subcategory'); console.log(jumpToValue);
        $('html,body').animate({scrollTop: $('[data-page-jump-to-href="'+jumpToValue+'"]').offset().top},'slow');
    }

}