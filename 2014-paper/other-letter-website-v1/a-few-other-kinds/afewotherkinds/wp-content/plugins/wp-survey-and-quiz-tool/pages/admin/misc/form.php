	<table class="form-table" id="question_form">
		<tbody>
			<?php foreach($options as $name => $option ){ ?>
			<tr>
				<th scope="row"><?php echo $option["display"]; ?></th>
				<td valign="top">
				<?php switch ($option["type"]) {
					case "text": ?>
				<input id="<?php echo $name; ?>" maxlength="255" size="50" name="<?php echo $name; ?>" value="<?php echo esc_attr(wp_kses_stripslashes($option["value"])); ?>" />
				<?php
						 break;
					case "select":
						?>
						<select id="<?php echo $name; ?>" name="<?php echo $name; ?>">
							<?php foreach( $option["args"] as $arg ){ ?>
							<option value="<?php echo stripslashes($arg); ?>"<?php if ($option["value"] == $arg) { ?> selected="selected"<?php } ?>><?php echo stripslashes($arg); ?></option>
							<?php } ?>
						</select>
						<?php
						break;
					case "yesno":
						?>
						<input type="radio" name="<?php echo $name; ?>" value="no" <?php if ( empty($option["value"]) || $option["value"] == 'no' ){ ?> checked="checked"<?php } ?> id="<?php echo $name; ?>_no" />
						<label for="<?php echo $name; ?>_no">No</label>
						<input type="radio" name="<?php echo $name; ?>" value="yes" <?php if ( $option["value"] == 'yes' ) {?> checked="checked"<?php } ?> id="<?php echo $name; ?>_yes" />
						<label for="<?php echo $name; ?>_yes">Yes</label>
						<?php
						break;
					case "textarea":
						?>
						<textarea name="<?php echo $name; ?>" rows="8" cols="40"><?php echo esc_html(wp_kses_stripslashes($option["value"])); ?></textarea>
						<?php
						break;
					case "static":
						?>
						<span style="background-color : #F2F5A9;"><?php echo $option["value"]; ?></span>
						<?php
						break;
					case 'image':
						if (isset($_GET['image']) && $_GET['image'] == 'remove') {
							$option['value'] = '';
						}
						$media_upload_iframe_src = "media-upload.php?question_id=".$name."&amp;app=wpsqt&amp;TB_iframe=true&amp;cb=" . rand();
						$image_upload_iframe_src = apply_filters('image_upload_iframe_src', $media_upload_iframe_src."&amp;type=image");
						?>
							<div id="image_<?php echo $name; ?>_link"><a href="<?php echo $image_upload_iframe_src; ?>" id="image_<?php echo $name; ?>_upload" class="thickbox" onclick="setId('<?php echo $name; ?>');" title="<?php echo $name ?>">Select/upload image</a></div>
							<div class="wpsqt_image" id="image_<?php echo $name; ?>_image"><?php echo stripslashes($option['value']); ?></div>
							<input type="hidden" name="<?php echo $name; ?>" id="image_<?php echo $name; ?>_text" value='<?php echo stripcslashes($option['value']); ?>' />
							<a href="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>&image=remove">Remove Image</a>
						<?php
						break;
				}?>
				</td>
				<td><?php echo $option["help"]; ?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
