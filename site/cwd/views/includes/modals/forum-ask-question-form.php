<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: forum-ask-question-forum.php
 * Author: Mike Giammattei
 * Created On: 12/6/2017, 3:29 PM
 */;
?>

<div id="ask-question-modal" class="modal modal-message fade forum-question-answer-modal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="pre-form-content">
					<div class="modal-header"><h3 class="blk-heading-md">Ask a Question</h3><p>You'll get one email when you receive your first answer — typically within 24 hours.</p></div>
					<hr>
				</div>
				<div class="success-box">
					<div class="modal-header">
						<h4 class="green-text-md">Submitted Successfully!</h4>
					</div>
					<p>Your question is very valuable to the entire Hopetracker community. It has been published for other users to share their feedback. </p>
				</div>
				<form class="pre-form-content" id="forum-ask-question-form">
					<div class="form-group category-form">
						<label for="categories">Choose a topic</label>
						<select name="categories" id="categories-select">
							<option data-toggle="tooltip" title="Required" >Select Topic</option>
							<?php foreach ( $Forum->get_category_list() as $category ) : ?>
								<option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group subcategory">
						<label for="categories">Sub-topic</label>
						<select name="categories" id="subcategories">
							<option title="Required">--</option>
						</select>
					</div>
					<div class="form-group question">
						<label for="question">Question</label>
						<input class="form-control" placeholder="What's your question?" id="question" name="question">
					</div>
					<div class="form-group description">
						<label for="description">Description</label>
						<textarea  class="form-control" placeholder="Short description" id="description" name="description"></textarea>
					</div>

					<button type="submit" class="btn btn-primary">Submit Question</button>
				</form>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</div>
