<?php
if (!class_exists('Sneeit_Controls')) :

define('SNEEIT_CONTROL_EDITOR_ID', 'sneeitframeworkcontroleditorid');

class Sneeit_Controls {	
	
	public $value = '';
	
	/**
	 * @access public
	 * @var string
	 */
	public $key = ''; // use this to check in data list, when id and name can be customize
	public $id = '';
	public $name = '';
	public $attr = array();

	/**
	 * @access public
	 * @var string
	 */
	public $type = 'text';
	
	/**
	 * @access public
	 * @var string
	 */
	public $title = '';
	public $label = '';

	/**
	 * @access public
	 * @var string
	 */
	public $description = '';
	
	/**
	 * @access public
	 * @var array
	 */
	public $choices = array();
	
	
	/**
	 * @access public
	 * @var mixed
	 */
	public $default = null;
	
	/**
	 * Show Heading above
	 * as separator of fieldset
	 * 
	 * @access public
	 * @var mixed
	 */
	public $heading = '';
	
	/**
	 * Save all args
	 * 
	 * @access public
	 * @var mixed
	 */
	public $args = array();
	
	
	/**
	 * Constructor.
	 *
	 * Supplied $args override class property defaults.
	 *
	 * @since 3.1.0
	 *
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $field_key, $args = array(), $value = null, $is_repeater_pattern = false) {
		$keys = array_keys( get_object_vars( $this ) );
		foreach ( $keys as $key ) {
			if ( isset( $args[ $key ] ) ) {
				$this->$key = $args[ $key ];
			}
		}
		
		$this->type = strtolower($this->type);
		
		$this->key = $field_key;
		
		
		$this->args = $args;
		
		// save value				
		if ($value !== null) {
			$this->value = $value;
		} else if ($this->default !== null && $this->value == null) {
			$this->value = $this->default;
		}
		
		// save id
		if (!isset($args['id'])) {
			$this->id = esc_attr(str_replace( array( '[', ']' ), array( '-', '' ), $this->key));
		}
		if (!isset($args['name'])) {
			$this->name = esc_attr(str_replace( array( '[', ']' ), array( '-', '' ), $this->key));
		}
		
		if ('content' == $this->type && 'content' == $this->id) {
			return;
		}
		
		// validate title
		if (!$this->title) {
			if ($this->label) {
				$this->title = $this->label;
			} else {
				$this->title = sneeit_slug_to_title($this->key);
			}
		}
		$this->args['title'] = $this->title;
		$this->args['default'] = $this->default;
		$this->args['value'] = $this->value;
			
		if (!$is_repeater_pattern) {
			$this->init_script();
		}
		
		if ('repeater' == $this->type && isset($this->args['fields']) && !$is_repeater_pattern) {
			$this->repeatable_render();
		} else {			
			$this->render();
		}
	}
	
	public function init_script() {
?><script type="text/javascript"><?php
	?>if (typeof(Sneeit_Controls_Defines) == 'undefined') {<?php
		?>Sneeit_Controls_Defines = new Object();<?php
	?>}<?php
	?>Sneeit_Controls_Defines['<?php echo $this->key; ?>'] = <?php echo json_encode($this->args); ?><?php
?></script><?php	
	}
	
	public function repeatable_render() {
		?><div class="sneeit-control-repeater-wrapper" <?php
		?>data-key="<?php echo esc_attr($this->key);?>"><?php
			?><div class="sneeit-control-repeater-header"><?php
				?><div class="sneeit-control-repeater-header-title"><?php 
					echo $this->title;				
				?></div><?php

				if ( ! empty( $this->description ) ) : 
				?><div class="sneeit-control-repeater-header-description"><?php 
					echo $this->description; 
				?></div><?php
				endif; 
			?></div><?php
			?><div class="sneeit-control-repeater-container"><?php
?><script type="text/javascript"><?php
	?>if (typeof(Sneeit_Controls_Defines) == 'undefined') {<?php
		?>Sneeit_Controls_Defines = new Object();<?php
	?>}<?php
	?>Sneeit_Controls_Defines['<?php echo $this->key; ?>'].pattern = <?php 
		ob_start();
		
		foreach ($this->args['fields'] as $control_id => $control_args) {
			new Sneeit_Controls($control_id, $control_args, '', true);
		}

		$data = ob_get_clean();
		echo json_encode($data); 
	?><?php
?></script><?php				
				
				?><div class="sneeit-control-repeater-container-value" <?php
				?>data-key="<?php echo esc_attr($this->key);?>"><?php
//					echo json_encode($this->value);
				?></div><?php
				
				?><div class="sneeit-control-repeater-container-items" <?php
				?>data-key="<?php echo esc_attr($this->key);?>"><?php
					// will be generated by JavaScript
				?></div><?php
				
				?><div class="sneeit-control-repeater-container-buttons" <?php
				?>data-key="<?php echo esc_attr($this->key);?>"><?php
					?><a href="javascript:void(0)" <?php
					?>class="button button-secondary button-sneeit-control-repeater-add" <?php
					?>data-key="<?php echo esc_attr($this->key);?>" <?php
					?>><?php
						esc_html_e('+ ADD NEW', 'sneeit');
					?></a><?php
				?></div><?php
			?></div><?php
		?></div><?php
	}
	
	/**
	 * Renders the control wrapper and call render_content
	 *
	 * @since 3.1.0
	 */
	public function render() {
		$id    = 'sneeit-control-' . $this->id;
		$class = 'sneeit-control sneeit-control-' . $this->type;
		
		if (isset($this->args['show']) || isset($this->args['hide'])) {
			$class .= ' sneeit-control-dependency';			
		}
		
		?><div id="<?php echo esc_attr( $id ); ?>" <?php
		?>data-key="<?php echo esc_attr( $this->key ); ?>" <?php
		?>data-type="<?php echo esc_attr( $this->type ); ?>" <?php
		?>class="<?php echo esc_attr( $class ); ?>"><?php 
			$this->render_content(); 
		?></div><?php
	}
	
	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See {@see WP_Customize_Control::print_template()}.
	 *
	 * @since 3.1.0
	 */
	protected function render_content() {
		// don't keep space here, some designs need display inline-block for elements
		// so space between them will effect designs
		
		if ($this->heading) :
			?>
			<div class="sneeit-control-separator" id="<?php echo sneeit_title_to_slug($this->heading);?>">
				<span><?php echo $this->heading; ?></span>
			</div>
			<?php
		endif;
		
		?><div class="sneeit-control-info"><?php
			?><div class="sneeit-control-title">
				<b><?php echo $this->title;?></b>
				<?php
				if ($this->default !== null && !in_array($this->type, array(
					'sidebar', 'sidebars', 'category', 'categories', 'tag', 'tags', 'user', 'users', 'selects'
				)) ) :
				?> <a href="javascript:void(0)" class="sneeit-control-reset-button noselect" <?php
				?>data-key="<?php echo esc_attr($this->key); ?>" <?php
				?>data-type="<?php echo esc_attr($this->type); ?>" <?php
				?>><?php
					esc_html_e('Reset', 'sneeit');
				?></a><?php
				endif;
			?></div><?php
			
			if ( ! empty( $this->description ) ) : 
			?><div class="sneeit-control-description"><?php 
				echo $this->description; 
			?></div><?php
			endif; 
		?></div><?php
			
		?><div class="sneeit-control-input"><?php				
			$control_value_holder_class = esc_attr('sneeit-control-'.$this->type.'-value sneeit-control-value');
			$control_attr = '';
			if (!empty($this->attr)) {
				foreach ($this->attr as $key => $value) {
					$control_attr.=$key.'="'.esc_attr($value).'" ';
				}
			}
			/* ********************* */
			/* OUT PUT CONTROLS HERE */			
			switch( $this->type ) {
								
				/* CATEGORY / TAG / USER */
				case 'category':
				case 'tag':
				case 'user':
					?><label><?php
						?><i class="fa fa-spin fa-spinner loading-icon"></i><?php
						?><select <?php
							echo $control_attr;
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?> ajax" <?php
							?>data-value="<?php echo esc_attr($this->value);?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>"><?php
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '">' . $label . '</option>';
							}
						?></select><?php
					?></label><?php
					break;
				
				/* CATOGORIES / TAGS / USERS */
				case 'categories':
				case 'tags':
				case 'users':
					?><label><?php
						?><i class="fa fa-spin fa-spinner loading-icon"></i><?php
						?><select <?php
							echo $control_attr;
							?>multiple="" <?php
							?>data-placeholder="<?php esc_attr_e('Type and Enter', 'sneeit');?>" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?> ajax" <?php
							?>data-value="<?php echo esc_attr($this->value);?>" <?php							
							?>id="<?php echo esc_attr( $this->id ); ?>"><?php
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '">' . $label . '</option>';
							}
						?></select><?php
					?></label><?php
					break;
				
				
				
				/* CHECKBOX */
				case 'checkbox':
					?><label><?php
						?><input <?php
							echo $control_attr;
							?>type="checkbox" <?php							
							?>class="<?php echo $control_value_holder_class;?>" <?php							
							?>name="<?php echo esc_attr($this->name); ?>" <?php
							?>id="<?php echo esc_attr($this->id); ?>" <?php
							checked( 'on', $this->value ); ?> /> <?php 	
							echo esc_html( $this->title ); 
					?></label><?php
					break;

				/* RADIO */
				case 'radio':
					foreach ( $this->choices as $value => $label ) :
						?><label><?php
							?><input <?php
								echo $control_attr;
								?>type="radio" <?php
								?>value="<?php echo esc_attr( $value ); ?>" <?php							
								?>class="<?php echo $control_value_holder_class;?>" <?php
								?>name="<?php echo esc_attr( $this->name ); ?>" <?php
								?>id="<?php echo esc_attr( $this->id ); ?>" <?php
								checked( $this->value, $value ); ?> /> <?php 
								echo esc_html( $label ); 
						?></label><?php
					endforeach;
					break;

				/* SELECT & SELECTS */
				case 'select':
					?><label><?php
						?><select <?php
							echo $control_attr;
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>"><?php					
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '"' . 
									selected( $this->value, $value, false ) . '>' . $label . '</option>';
							}
						?></select><?php
					?></label><?php
					break;
					
				case 'selects':
					?><label><?php
						if (!$this->value) {
							$this->value = '';
						}
						?><select <?php
							echo $control_attr;
							?>multiple="" <?php
							?>data-placeholder="<?php esc_attr_e('Type and Enter', 'sneeit');?>" <?php
							?>data-value="<?php echo esc_attr( $this->value ); ?>" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>"><?php					
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '">' . $label . '</option>';
							}
						?></select><?php
					?></label><?php
					break;

				/* TEXTAREA / CONTENT */
				case 'content':

					
					?><textarea <?php
						echo $control_attr;
						?>rows="5" cols="5"<?php
						?>class="<?php echo $control_value_holder_class;?> html-field wp-editor-area" <?php
						?>name="<?php echo esc_attr( $this->name ); ?>" <?php
						?>id="<?php echo esc_attr( $this->id ); ?>"><?php 						
						echo esc_textarea( $this->value );
					?></textarea><?php			
					break;
				
				case 'textarea':
					?><label><?php								
						?><textarea <?php
							echo $control_attr;
							?>rows="5" cols="5"<?php
							?>class="<?php echo $control_value_holder_class;?> html-field wp-editor-area" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>"><?php 						
							echo esc_textarea( $this->value );
						?></textarea><?php
					?></label><?php
					break;

				/* COLOR */
				case 'color':
					?><label><?php
						?><input <?php
							echo $control_attr;
							?>type="text" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>" <?php
							?>value="<?php echo esc_attr( $this->value ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							if ($this->default): 
							?>data-default-color="<?php echo esc_attr(($this->default));?>" <?php
							endif;
							?>/><?php
					?></label><?php
					break;

				/* MEDIA */
				case 'media':
					?><label><?php
						?><span class="sneeit-control-media-input-left"><?php
							?><input <?php
								echo $control_attr;
								?>type="url" <?php
								?>name="<?php echo esc_attr( $this->name ); ?>" <?php
								?>id="<?php echo esc_attr( $this->id ); ?>" <?php
								?>value="<?php echo esc_attr( $this->value ); ?>" <?php
								?>class="<?php echo $control_value_holder_class;?>"/><?php
						?></span><?php
						?><span class="sneeit-control-media-input-right"><?php
							?><a href="javascript:void(0)" <?php
								?>data-key="<?php echo esc_attr( $this->key ); ?>" <?php
								?>class="sneeit-control-media-upload-button button button-secondary"><?php
									esc_html_e('Upload File', 'sneeit');
							?></a><?php
						?></span><?php
					?></label><?php
					break;

				/* IMAGE */
				case 'image':
					?><label><?php
						?><span class="sneeit-control-image-input-left"><?php
							?><span class="sneeit-control-image-preview" data-key="<?php echo esc_attr( $this->key ); ?>"><?php
							if ($this->value) :
								?><img src="<?php echo esc_attr($this->value);?>"/><?php
							else:
								?><i class="fa fa-plus"></i><?php
							endif;
							?></span><?php
						?></span><?php
						?><span class="sneeit-control-image-input-right"><?php					
							?><input <?php
								echo $control_attr;
								?>type="url" <?php
								?>name="<?php echo esc_attr( $this->name ); ?>" <?php
								?>id="<?php echo esc_attr( $this->id ); ?>" <?php
								?>value="<?php echo esc_attr( $this->value ); ?>" <?php
								?>class="<?php echo $control_value_holder_class;?>"/><?php
							?><span class="sneeit-control-image-buttons"><?php
								?><a href="javascript:void(0)" <?php
									disabled($this->value, '');
									?>data-key="<?php echo esc_attr( $this->key ); ?>" <?php
									?>class="sneeit-control-image-remove-button button button-secondary"><?php
									esc_html_e('Remove', 'sneeit');
								?></a><?php
								?><a href="javascript:void(0)" <?php
									?>data-key="<?php echo esc_attr( $this->key ); ?>" <?php
									?>class="sneeit-control-image-upload-button button button-secondary"><?php
									esc_html_e('Upload', 'sneeit');
								?></a><?php
							?></span><?php
						?></span><?php
					?></label><?php
					break;

				/* RANGE */
				case 'range':
					?><label><?php
						?><span class="sneeit-control-range-input-left"><?php
							?><span class="sneeit-control-range-slider" data-key="<?php echo esc_attr( $this->key ); ?>"><?php
							?></span><?php
						?></span><?php

						?><span class="sneeit-control-range-input-right"><?php
							?><input <?php
							echo $control_attr;
							?>type="hidden" readonly="" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>" <?php

							if (isset($this->args['min'])):
							?>min="<?php echo esc_attr($this->args['min']);?>"<?php
							endif;

							if (isset($this->args['max'])):
							?>max="<?php echo esc_attr($this->args['max']);?>"<?php
							endif;

							if (isset($this->args['step'])):
							?>step="<?php echo esc_attr($this->args['step']);?>"<?php
							endif;

							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>value="<?php echo esc_attr( $this->value ); ?>" /><?php
							?><span class="sneeit-control-range-value-number" <?php
							?>data-key="<?php echo esc_attr( $this->key ); ?>"><?php 
								echo esc_attr( $this->value ); 
							?></span><?php
						?></span><?php	
					?></label><?php
					break;

				/* SIDEBAR & SIDEBARS */
				case 'sidebars':
					if (!$this->value) {
						$this->value = '';
					}
					?><label><?php
						?><select <?php
							echo $control_attr;
							?>multiple="" <?php
							?>data-placeholder="<?php esc_attr_e('Type and Enter', 'sneeit');?>" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>" <?php		
							?>data-value="<?php echo esc_attr( $this->value ); ?>"><?php
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '">' . $label . '</option>';
							}
						?></select><?php
					?></label><?php
					break;
					
				case 'sidebar':				
					if (!$this->value) {
						$this->value = '';
					}
					?><label><?php
						?><select <?php
							echo $control_attr;
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>" <?php		
							?>data-value="<?php echo esc_attr( $this->value ); ?>"><?php
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '">' . $label . '</option>';
							}
						?></select><?php
					?></label><?php
					break;

				/* VISUAL PICKER */
				case 'visual':
					?><label><?php									
						?><input <?php
							echo $control_attr;
							?>type="hidden" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>value="<?php echo esc_attr( $this->value ); ?>" /><?php
							foreach ($this->choices as $value => $html) :
								?><a href="javascript:void(0)" <?php
								?>data-value="<?php echo esc_attr($value); ?>" <?php
								?>data-key="<?php echo esc_attr($this->key); ?>" <?php
								?>class="sneeit-control-visual-picker<?php
								if ($value == $this->value) :
									echo ' active';
								else:
									echo ' inactive';
								endif;
								?>"><?php
								echo $html;
								?></a><?php
							endforeach;
					?></label><?php
					break;

				/* FONT FAMILY & font*/
				case 'font-family':
				case 'font':
					global $Sneeit_Safe_Fonts;
					global $Sneeit_Google_Fonts;
					global $Sneeit_Upload_Fonts;
					global $Sneeit_Font_Sizes;
					
					if (null === $Sneeit_Upload_Fonts) {
						sneeit_get_uploaded_fonts();
					}					

					$font_family = $this->value;

					if ('font' == $this->type) {
						$the_value = $this->value;
						$the_value = explode(' ', $the_value);
						$font_style = '';
						$font_weight = '';
						$font_size = '';
						$font_family = '';

						// parse value to elements
						foreach ($the_value as $key => $value) {
							switch ($key) {
								case 0:
									$font_style = $value;
									break;

								case 1:
									$font_weight = $value;
									break;

								case 2:
									$font_size = $value;
									break;

								default:
									if ($font_family) {
										$font_family .= ' ';
									}
									$font_family .= $value;
									$font_family = str_replace('\'', '', $font_family);
									$font_family = str_replace('"', '', $font_family);
									break;
							}
						}

						// valid font size
						$font_size = (int) str_replace('px', '', $font_size);
						global $Sneeit_Font_Sizes;
						if (!in_array($font_size, $Sneeit_Font_Sizes)) {
							foreach ($Sneeit_Font_Sizes as $index => $size) :
								if ($font_size < $size) {
									array_splice($Sneeit_Font_Sizes, $index, 0, $font_size);
									break;
								}
							endforeach;
						}
					}

					?><div class="sneeit-control-font-ui" data-key="<?php echo $this->key; ?>"><?php
						?><div class="font-family collapsed"><?php
							?><div class="font-family-value"><?php
								?><input readonly="true" class="value noselect" <?php
								?>value="<?php echo esc_attr($font_family); ?>" <?php
								?>style="<?php
								echo 'font-family: '.esc_attr($font_family).';';
								if ('font' == $this->type) {
									if ('italic' == $font_style) {
										echo 'font-style: italic;';
									}
									if ('bold' == $font_weight) {
										echo 'font-weight: bold;';
									}
								}

								?>" <?php
								?>/><?php
								?><a href="javascript:void(0)" class="drop"><?php
									?><i class="fa fa-chevron-down icon-down icon"></i><?php
									?><i class="fa fa-chevron-up icon-up icon"></i><?php
								?></a><?php
							?></div><?php

							?><div class="font-family-list scrollbar"><?php
							
								if (is_array($Sneeit_Upload_Fonts) && count($Sneeit_Upload_Fonts)):
									foreach ($Sneeit_Upload_Fonts as $font_name => $font_property) : 
										?><a class="upload-font font-family-item <?php 
									if ($font_name == $font_family) {
										echo 'active';
									} else {
										echo 'inactive';
									}
								?>" data-font_name="<?php echo esc_attr($font_name); ?>"><?php
											echo '<span class="value">'.$font_name .'</span>';
										?></a><?php 										
									endforeach; 
									?><span class="spliter"></span><?php 
								endif; 
								
								foreach ($Sneeit_Safe_Fonts as $font_name => $font_property) : 
								?><a class="safe-font font-family-item <?php 
									if ($font_name == $font_family) {
										echo 'active';
									} else {
										echo 'inactive';
									}
								?>" data-font_name="<?php echo esc_attr($font_name); ?>"><?php
									echo '<span class="value">'.$font_name .'</span>';
								?></a><?php 
								endforeach; 

								?><span class="spliter"></span><?php 
								foreach ($Sneeit_Google_Fonts as $font_name => $font_property) : 
								?><a class="google-font font-family-item <?php 
									if ($font_name == $font_family) {
										echo 'active';
									} else {
										echo 'inactive';
									}
								?>" data-font_name="<?php echo esc_attr($font_name); ?>"><?php
									echo '<span class="value">'.$font_name .'</span>';
								?></a><?php 
								endforeach; 
								
							?></div><?php /* end of font-family-list*/

						?></div><?php



						if ('font' == $this->type) :
							?><div class="font-design"><?php
								?><a class="noselect font-style-value <?php 
									if ('italic' == $font_style) {
										echo 'active';
									} else {
										echo 'inactive';
									}
								?>"><?php
									?><span class="value">I</span><?php
								?></a><?php

								?><a class="noselect font-weight-value <?php 
									if ('bold' == $font_weight) {
										echo 'active';								
									} else {
										echo 'inactive';
									} 
								?>"><?php
									?><span class="value">B</span><?php
								?></a><?php

								?><select class="font-size-value"><?php					
									foreach ($Sneeit_Font_Sizes as $size) :
										?><option value="<?php echo $size; ?>px"<?php 
										selected($font_size, $size); ?>><?php 
											echo $size . 'px';
										?></option><?php
									endforeach;
								?></select><?php
							?></div><?php
						endif;

					?></div><?php /* end of control-font*/
					?><label><?php
						?><input type="hidden" <?php
							echo $control_attr;
							?>id="<?php echo $this->id; ?>" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php					
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>value="<?php echo esc_attr( $this->value ); ?>"/>
					</label>
					<?php
					break;
					
					
				/* box-model: PADDING / MARGIN / BORDER / POSITION */
				case 'box-padding':
				case 'box-margin':
				case 'box-position':
				case 'box-padding-px':
				case 'box-margin-px':
				case 'box-position-px':
					$the_value = explode(' ', $this->value);
					$force_unit = false;
					
					$top = $the_value[0];
					$right = $the_value[1];
					$bottom = $the_value[2];
					$left = $the_value[3];					
					
					$top_value = str_replace(array('px', '%'), '', $top);
					$top_unit = str_replace($top_value, '', $top);
					
					$right_value = str_replace(array('px', '%'), '', $right);
					$right_unit = str_replace($right_value, '', $right);
					
					$bottom_value = str_replace(array('px', '%'), '', $bottom);
					$bottom_unit = str_replace($bottom_value, '', $bottom);
					
					$left_value = str_replace(array('px', '%'), '', $left);
					$left_unit = str_replace($left_value, '', $left);
					
					if (in_array($this->type, array(
							'box-padding-px',
							'box-margin-px',
							'box-position-px')
						)) {
						$top_unit = $right_unit = $bottom_unit = $left_unit = 'px';
						$force_unit = true;
					}


					?><div class="sneeit-control-<?php echo esc_attr($this->type); ?>-ui sneeit-control-box-model-ui" data-key="<?php echo esc_attr($this->key); ?>"><?php
						?><div class="sneeit-control-box-model-ui-cell cell-top-left"><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-top"><?php
							?><input class="sneeit-control-box-model-top-value" value="<?php
								echo esc_attr($top_value);
							?>"/><?php
							?><input class="sneeit-control-box-model-top-unit" value="<?php
								echo esc_attr($top_unit);
							?>"<?php if ($force_unit) {echo ' readonly="true"';} ?>/><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-top-right"><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-left"><?php
							?><input class="sneeit-control-box-model-left-value" value="<?php
								echo esc_attr($left_value);
							?>"/><?php
							?><input class="sneeit-control-box-model-left-unit" value="<?php
								echo esc_attr($left_unit);
							?>"<?php if ($force_unit) {echo ' readonly="true"';} ?>/><?php														
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-middle-center"><?php
							?><div class="sneeit-control-box-model-ui-cell-middle-center-inner"><?php
							?></div><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-right"><?php							
							?><input class="sneeit-control-box-model-right-value" value="<?php
								echo esc_attr($right_value);
							?>"/><?php
							?><input class="sneeit-control-box-model-right-unit" value="<?php
								echo esc_attr($right_unit);
							?>"<?php if ($force_unit) {echo ' readonly="true"';} ?>/><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-bottom-left"><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-bottom"><?php
							?><input class="sneeit-control-box-model-bottom-value" value="<?php
								echo esc_attr($bottom_value);
							?>"/><?php
							?><input class="sneeit-control-box-model-bottom-unit" value="<?php
								echo esc_attr($bottom_unit);
							?>"<?php if ($force_unit) {echo ' readonly="true"';} ?>/><?php
						?></div><?php
						?><div class="sneeit-control-box-model-ui-cell cell-bottom-right"><?php
						?></div><?php												
					?></div><?php /* end of control-box-model*/
					
					?><label><?php
						?><input type="hidden" <?php
							echo $control_attr;
							?>id="<?php echo $this->id; ?>" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php					
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>value="<?php echo esc_attr( $this->value ); ?>"/>
					</label>
					<?php
					break;
										
/*******************************************/
/*
  ________   _______   ____  _____ _______ 
 |  ____\ \ / /  __ \ / __ \|  __ \__   __|
 | |__   \ V /| |__) | |  | | |__) | | |   
 |  __|   > < |  ___/| |  | |  _  /  | |   
 | |____ / . \| |    | |__| | | \ \  | |   
 |______/_/ \_\_|     \____/|_|  \_\ |_|   
                                           
 */					
/********************************************/
				case 'export':					
					?><a href="<?php echo esc_attr(admin_url( 'customize.php' ) . '?'.SNEEIT_KEY_SNEEIT_EXPORT.'=' . wp_create_nonce( SNEEIT_KEY_SNEEIT_EXPORT )); ?>" class="button"><?php 
						_e('Export', 'sneeit');
					?></a><?php		
					break;
				
/*******************************************/
/*
   _____ __  __ _____   ____  _____ _______ 
 |_   _|  \/  |  __ \ / __ \|  __ \__   __|
   | | | \  / | |__) | |  | | |__) | | |   
   | | | |\/| |  ___/| |  | |  _  /  | |   
  _| |_| |  | | |    | |__| | | \ \  | |   
 |_____|_|  |_|_|     \____/|_|  \_\ |_|   
                                           
 */					
/********************************************/
				case 'import':
					?><input name="<?php echo esc_attr(SNEEIT_KEY_SNEEIT_IMPORT); ?>-file" type="file"/> <?php
					?><div class="<?php echo esc_attr(SNEEIT_KEY_SNEEIT_IMPORT); ?>-msg" style="display:none"><?php 
						_e('Importing ...', 'sneeit');
					?></div><?php
					?><a href="javascript:void(0)" class="button <?php echo esc_attr(SNEEIT_KEY_SNEEIT_IMPORT); ?>-submit"><?php 
						_e('Import', 'sneeit');
					?></a><?php
					
					if (get_transient(SNEEIT_KEY_SNEEIT_IMPORT)) {
						?><script><?php 
							?>alert("<?php echo esc_attr(get_transient(SNEEIT_KEY_SNEEIT_IMPORT)); ?>");<?php
						?></script><?php
							delete_transient(SNEEIT_KEY_SNEEIT_IMPORT);
					}					
					break;
				
/********************************************/
/*
  _____  ______ ______     _    _ _   _______ 
 |  __ \|  ____|  ____/\  | |  | | | |__   __|
 | |  | | |__  | |__ /  \ | |  | | |    | |   
 | |  | |  __| |  __/ /\ \| |  | | |    | |   
 | |__| | |____| | / ____ \ |__| | |____| |   
 |_____/|______|_|/_/    \_\____/|______|_|   
                                              
 */				
/*********************************************/					
				default:					
					?><label><?php
						?><input <?php
							echo $control_attr;
							?>type="<?php echo esc_attr( $this->type ); ?>" <?php
							?>name="<?php echo esc_attr( $this->name ); ?>" <?php
							?>id="<?php echo esc_attr( $this->id ); ?>" <?php
							?>class="<?php echo $control_value_holder_class;?>" <?php
							?>value="<?php echo esc_attr( $this->value ); ?>" /><?php
					?></label><?php
					break;
			} /* end of SWITCH types */
		?></div><!-- .sneeit-control-input --><?php
	}
} /* end of class define */

// https://stackoverflow.com/questions/21519322/use-wordpress-wp-editor-in-dynamic-ajax-html
add_action( 'admin_print_footer_scripts', 'sneeit_controls_enqueue', 1); // use 51 to load after wp editor
function sneeit_controls_enqueue() {

	wp_editor('', SNEEIT_CONTROL_EDITOR_ID);
	
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_style( 'sneeit-plugin-chosen');
	wp_enqueue_script( 'sneeit-plugin-chosen');
	wp_enqueue_script('sneeit-web-fonts');
	wp_enqueue_script('sneeit-lib');
	wp_enqueue_style('sneeit-controls', SNEEIT_PLUGIN_URL_CSS .'controls.css', array(), SNEEIT_PLUGIN_VERSION);
	wp_add_inline_style('sneeit-controls', '
	#wp-'.SNEEIT_CONTROL_EDITOR_ID.'-wrap {display: none!important;}
	');
	
	wp_enqueue_script('sneeit-controls', SNEEIT_PLUGIN_URL_JS . 'controls.js', array(
		'jquery',
		'editor',
		'quicktags',
		'sneeit-lib',
		'wp-color-picker',
		'jquery-ui-slider',
		'sneeit-web-fonts'
	), SNEEIT_PLUGIN_VERSION);
	
	
	wp_localize_script('sneeit-controls', 'Sneeit_Controls', array(
		'text' => array(
			'input_your_value' => esc_html__('Input Your Value', 'sneeit'),
			'ajax_error_message' => esc_html__('Can Not Load Data for Some Fields', 'sneeit'),
			'empty_import' => esc_html__('Please choose a file to import', 'sneeit'),
		),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'sneeit_controls_editor_id' => SNEEIT_CONTROL_EDITOR_ID,
		'export_key' => SNEEIT_KEY_SNEEIT_EXPORT,
		'import_key' => SNEEIT_KEY_SNEEIT_IMPORT,	
		'import_nonce' => esc_attr(wp_create_nonce( SNEEIT_KEY_SNEEIT_IMPORT)),		
		'import_action' => esc_attr(admin_url( 'customize.php' )),		
	));
	
	
	
	global $wp_registered_sidebars;
	unset($wp_registered_sidebars['wp_inactive_widgets']);
	wp_localize_script('sneeit-controls', 'Sneeit_Controls_Sidebars', $wp_registered_sidebars);
	
	global $Sneeit_Safe_Fonts;
	global $Sneeit_Google_Fonts;
	global $Sneeit_Upload_Fonts;
	global $Sneeit_Font_Sizes;


	wp_localize_script('sneeit-controls', 'Sneeit_Controls_Fonts', array(
		'safe' => $Sneeit_Safe_Fonts,
		'google' => $Sneeit_Google_Fonts,
		'upload' => $Sneeit_Upload_Fonts
	));	
}

endif;