<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: forum-answer-form.php.
 * Author: Mike Giammattei
 * Created On: 12/6/2017, 3:34 PM
 */;
?>

<div id="answer-question-modal" class="modal modal-message fade forum-question-answer-modal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="pre-form-content">
					<div class="modal-header"><h3 class="blk-heading-md">Answer the  Question</h3></div>
					<hr>
				</div>
				<div class="success-box">
					<div class="modal-header">
						<h4 class="green-text-md">Submitted Successfully!</h4>
					</div>
					<p>Your answer is very valuable to the entire Hopetracker community. </p>
				</div> 
				<form class="pre-form-content" id="forum-answer-question-form">
					<div data-question-out="text" id="question" class="form-group"></div>
					<div class="form-group answer text-left">
						<textarea  class="form-control" placeholder="Enter you answer" id="answer" name="answer"></textarea>
					</div>

					<button type="submit" class="btn btn-primary">Submit Answer</button>
				</form>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</div>
