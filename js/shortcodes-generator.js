(function() {
	tinymce.PluginManager.add('dgts_mce_button', function( editor, url ) {
		editor.addButton( 'dgts_mce_button', {
			text: 'DGTS',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text: dgts.grid_shortcode,
					menu: [
						{
							text: dgts.section_shortcode,
							onclick: function() {
								editor.windowManager.open( {
									title: dgts.section_options,
									body: [
										{
											type: 'listbox',
											name: 'section_full',
											label: dgts.section_full,
											'values': [
												{text: dgts.no, value: 'no'},
												{text: dgts.yes, value: 'yes'}
											]
										},
										{
											type: 'textbox',
											name: 'section_color',
											label: dgts.section_color,
											value: 'transparent'
										},
										{
											type: 'textbox',
											name: 'section_image',
											label: dgts.section_image,
											value: ''
										},
										{
											type: 'listbox',
											name: 'section_repeat',
											label: dgts.section_repeat,
											'values': [
												{text: dgts.section_repeat_no, value: 'no-repeat'},
												{text: dgts.section_repeat_yes, value: 'repeat'},
												{text: dgts.section_repeat_x, value: 'repeat-x'},
												{text: dgts.section_repeat_y, value: 'repeat-y'}
											]
										},
										{
											type: 'listbox',
											name: 'section_attachment',
											label: dgts.section_attachment,
											'values': [
												{text: dgts.section_attachment_scroll, value: 'scroll'},
												{text: dgts.section_attachment_fixed, value: 'fixed'}
											]
										},
										{
											type: 'listbox',
											name: 'section_size',
											label: dgts.section_size,
											'values': [
												{text: dgts.section_size_auto, value: 'auto'},
												{text: dgts.section_size_cover, value: 'cover'}
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '<br>[section full="' + e.data.section_full + '" color="' + e.data.section_color + '" image="' + e.data.section_image + '" repeat="' + e.data.section_repeat + '" attach="' + e.data.section_attachment + '" size="' + e.data.section_size + '"]<br><br>[/section]');
									}
								});
							}
						},
						{
							text: dgts.row_shortcode,
							onclick: function() {
								editor.windowManager.open( {
									title: dgts.row_options,
									body: [
										{
											type: 'textbox',
											name: 'row_width',
											label: dgts.row_width,
											value: '1200',
											tooltip: dgts.row_width_tooltip
										},
										{
											type: 'textbox',
											name: 'row_height',
											label: dgts.row_height,
											value: '',
											tooltip: dgts.row_height_tooltip
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[row width="' + e.data.row_width + '" height="' + e.data.row_height + '"]<br>[/row]');
									}
								});
							}
						},
						{
							text: dgts.columns_shortcode,
							onclick: function() {
								editor.windowManager.open( {
									title: dgts.columns_options,
									body: [
										{
											type: 'textbox',
											name: 'column_width',
											label: dgts.columns_width,
											value: '33.333% + 33.333% + 33.333%'
										}
									],
									onsubmit: function( e ) {

										var columns = '';
										columns = e.data.column_width;
										var str_array = columns.split('+');

										if (columns != '') {
											for(var i = 0; i < str_array.length; i++){
												count = i + 1;
												str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
												editor.insertContent( '<br>[columns qty="' + str_array[i] + '"]<br><br>Column ' + count + '<br><br>[/columns]' );
											}
										}
									}
								});
							}
						}
					]
				},
				{
					text: dgts.price_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.price_options + ' ' + dgts.step_one,
							body: [
								{
									type: 'textbox',
									name: 'pt_per_row',
			                        minWidth: 150,
									label: dgts.price_per_row,
									value: '3'
								}
							],
			                onsubmit: function(e) {
			                    var pt_total_items = e.data.pt_per_row;
			                    var pricingTablesItemsForm = [];
			                    for( var i = 1; i <= pt_total_items; i++ )
			                    {
			                        pricingTablesItemsForm.push(
			                            {
				                            title: dgts.price_table + ' ' + i,
				                            name: 'pt_item_' + i,
				                            type: 'form',
				                            items: [
				                                {
				                                    label: dgts.price_table + ' ' + i,
				                                    name: 'pt_item_html_' + i,
				                                    type: 'container'
				                                },
												{
													type: 'textbox',
													name: 'pt_title_' + i,
													label: dgts.price_title,
													value: dgts.price_title_silver
												},
												{
													type: 'listbox',
													name: 'pt_featured_' + i,
													label: dgts.pricing_featured,
													'values': [
														{text: dgts.yes, value: 'yes'},
														{text: dgts.no, value: 'no'}
													]
												},
												{
													type: 'textbox',
													name: 'pt_price_' + i,
													label: dgts.price_price,
													value: dgts.price_currency
												},
												{
													type: 'textbox',
													name: 'pt_per_' + i,
													label: dgts.price_fee,
													value: dgts.price_fee_monthly
												},
												{
													type: 'textbox',
													name: 'pt_btn_txt_' + i,
													label: dgts.price_button,
													value: dgts.price_button_text
												},
												{
													type: 'textbox',
													name: 'pt_btn_url_' + i,
													label: dgts.price_button_url,
													value: 'http://google.com'
												}
			                                ]
			                            }
			                        )
			                    }
			                    win = editor.windowManager.open({
			                        minWidth: 600,
			                        resizable: true,
			                        classes: 'largemce-panel',
			                        title: dgts.price_options + ' ' + dgts.step_two,
			                        body: pricingTablesItemsForm,
									onsubmit: function( e ) {

										var pt_output = '[pricing_tables]<br>';

										for (var i = 0; i < pt_total_items; i++){

					                        var count = i + 1,
					                        	get_pt_title = String('e.data.pt_title_' + count),
					                        	get_pt_featured = String('e.data.pt_featured_' + count),
					                        	get_pt_price = String('e.data.pt_price_' + count),
					                        	get_pt_per = String('e.data.pt_per_' + count),
					                        	get_pt_btn_txt = String('e.data.pt_btn_txt_' + count),
					                        	get_pt_btn_url = String('e.data.pt_btn_url_' + count),
                                				pt_title = eval(get_pt_title),
                                				pt_featured = eval(get_pt_featured),
                                				pt_price = eval(get_pt_price),
                                				pt_per = eval(get_pt_per),
                                				pt_btn_txt = eval(get_pt_btn_txt),
                                				pt_btn_url = eval(get_pt_btn_url);

											pt_output += '[pricing_table per_row="' + pt_total_items + '" featured="' + pt_featured + '" title="' + pt_title + '" price="' + pt_price + '" per="' + pt_per + '" button_txt="' + pt_btn_txt + '" button_url="' + pt_btn_url + '"]<br>[pricing_feature]' + dgts.price_sample_text + '[/pricing_feature]<br>[pricing_feature]' + dgts.price_sample_text + '[/pricing_feature]<br>[pricing_feature]' + dgts.price_sample_text + '[/pricing_feature]<br>[/pricing_table]<br>';
										}
										
										pt_output += '[/pricing_tables]';

					                    editor.insertContent( pt_output );
									}
			                    });
			                }
						});
					}
				},
				{
					text: dgts.counters_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.counters_options + ' ' + dgts.step_one,
							body: [
								{
									type: 'textbox',
									name: 'counters_per_row',
			                        minWidth: 150,
									label: dgts.counters_per_row,
									value: '4'
								}
							],
			                onsubmit: function(e) {
			                    var counters_total_items = e.data.counters_per_row;
			                    var countersItemsForm = [];
			                    for( var i = 1; i <= counters_total_items; i++ )
			                    {
			                        countersItemsForm.push(
			                            {
				                            title: dgts.counter_item + ' ' + i,
				                            name: 'counters_item_' + i,
				                            type: 'form',
				                            items: [
				                                {
				                                    label: dgts.counter_item + ' ' + i,
				                                    name: 'counters_item_html_' + i,
				                                    type: 'container'
				                                },
												{
													type: 'textbox',
													name: 'counters_qty_' + i,
													label: dgts.counters_number,
													value: '2545'
												},
												{
													type: 'textbox',
													name: 'counters_before_' + i,
													label: dgts.counters_before,
													value: '+'
												},
												{
													type: 'textbox',
													name: 'counters_after_' + i,
													label: dgts.counters_after,
													value: dgts.counters_currency
												},
												{
													type: 'textbox',
													name: 'counters_txt_' + i,
													label: dgts.counters_title,
													value: dgts.counters_title_text
												}
			                                ]
			                            }
			                        )
			                    }
			                    win = editor.windowManager.open({
			                        minWidth: 600,
			                        resizable: true,
			                        classes: 'largemce-panel',
			                        title: dgts.counters_options + ' ' + dgts.step_two,
			                        body: countersItemsForm,
									onsubmit: function( e ) {

										var counters_output = '[counters]<br>';

										for (var i = 0; i < counters_total_items; i++){

					                        var count = i + 1,
					                        	get_counters_qty = String('e.data.counters_qty_' + count),
					                        	get_counters_before = String('e.data.counters_before_' + count),
					                        	get_counters_after = String('e.data.counters_after_' + count),
					                        	get_counters_txt = String('e.data.counters_txt_' + count),
                                				counters_qty = eval(get_counters_qty),
                                				counters_before = eval(get_counters_before),
                                				counters_after = eval(get_counters_after),
                                				counters_txt = eval(get_counters_txt);

											counters_output += '[counter qty="' + counters_qty + '" before="' + counters_before + '" after="' + counters_after + '" txt="' + counters_txt + '"]<br>';
										}
										
										counters_output += '[/counters]';

					                    editor.insertContent( counters_output );
									}
			                    });
			                }
						});
					}
				},
				{
					text: dgts.coundown_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.countdown_options,
							body: [
								{
									type: 'textbox',
									name: 'cdn_day',
									label: dgts.countdown_day,
									value: '1'
								},
								{
									type: 'textbox',
									name: 'cdn_month',
									label: dgts.countdown_month,
									value: '1'
								},
								{
									type: 'textbox',
									name: 'cdn_year',
									label: dgts.countdown_year,
									value: '2017'
								},
								{
									type: 'textbox',
									name: 'cdn_hour',
									label: dgts.countdown_hour,
									value: '00'
								},
								{
									type: 'textbox',
									name: 'cdn_minute',
									label: dgts.countdown_minutes,
									value: '00'
								},
								{
									type: 'textbox',
									name: 'cdn_seconds',
									label: dgts.countdown_seconds,
									value: '00'
								},
								{
									type: 'textbox',
									name: 'cdn_txt',
									label: dgts.countdown_txt,
									value: dgts.countdown_txt_output
								}
							],
							onsubmit: function( e ) {
								editor.insertContent( '[countdown_clock day="' + e.data.cdn_day + '" month="' + e.data.cdn_month + '" year="' + e.data.cdn_year + '" hour="' + e.data.cdn_hour + '" minutes="' + e.data.cdn_minute + '" seconds="' + e.data.cdn_seconds + '" txt="' + e.data.cdn_txt + '"]');
							}
						});
					}
				},
				{
					text: dgts.posts_carousel_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.posts_carousel_options,
							body: [
								{
									type: 'textbox',
									name: 'posts_show',
									label: dgts.posts_carousel_show,
									value: '',
									tooltip: dgts.posts_carousel_show_tooltip
								},
								{
									type: 'textbox',
									name: 'posts_per_slide',
									label: dgts.posts_carousel_slide,
									value: '3'
								},
								{
									type: 'textbox',
									name: 'posts_category',
									label: dgts.posts_carousel_category,
									value: ''
								},
								{
									type: 'listbox',
									name: 'posts_meta',
									label: dgts.posts_carousel_meta,
									'values': [
										{text: dgts.yes, value: 'yes'},
										{text: dgts.no, value: 'no'}
									]
								},
								{
									type: 'listbox',
									name: 'posts_date',
									label: dgts.posts_carousel_date,
									'values': [
										{text: dgts.yes, value: 'yes'},
										{text: dgts.no, value: 'no'}
									]
								},
								{
									type: 'textbox',
									name: 'posts_more',
									label: dgts.posts_carousel_more,
									value: dgts.posts_carousel_more_text
								},
								{
									type: 'listbox',
									name: 'posts_order',
									label: dgts.posts_carousel_order,
									'values': [
										{text: dgts.descending, value: 'DESC'},
										{text: dgts.ascending, value: 'ASC'}
									]
								},
								{
									type: 'listbox',
									name: 'posts_orderby',
									label: dgts.orderby,
									'values': [
										{text: dgts.by_date, value: 'date'},
										{text: dgts.by_comment, value: 'comment_count'},
										{text: dgts.by_title, value: 'title'},
										{text: dgts.by_modified, value: 'modified'},
										{text: dgts.by_rand, value: 'rand'}
									]
								}
							],
							onsubmit: function( e ) {
								editor.insertContent( '[posts_carousel show="' + e.data.posts_show + '" slide="' + e.data.posts_per_slide + '" category="' + e.data.posts_category + '" meta="' + e.data.posts_meta + '" date="' + e.data.posts_date + '" more="' + e.data.posts_more + '" order="' + e.data.posts_order + '" orderby="' + e.data.posts_orderby + '"]');
							}
						});
					}
				},
				{
					text: dgts.logos_carousel_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.logos_carousel_options,
							body: [
								{
									type: 'textbox',
									name: 'logos_show',
									label: dgts.logos_carousel_show,
									value: ''
								},
								{
									type: 'textbox',
									name: 'logos_slide',
									label: dgts.logos_carousel_slide,
									value: '5'
								},
								{
									type: 'textbox',
									name: 'logos_ids',
									label: dgts.logos_carousel_ids,
									value: ''
								},
								{
									type: 'listbox',
									name: 'logos_order',
									label: dgts.logos_carousel_order,
									'values': [
										{text: dgts.descending, value: 'DESC'},
										{text: dgts.ascending, value: 'ASC'}
									]
								},
								{
									type: 'listbox',
									name: 'logos_orderby',
									label: dgts.orderby,
									'values': [
										{text: dgts.by_date, value: 'date'},
										{text: dgts.by_ID, value: 'ID'},
										{text: dgts.by_modified, value: 'modified'},
										{text: dgts.by_rand, value: 'rand'}
									]
								}
							],
							onsubmit: function( e ) {
								editor.insertContent( '[logos_carousel show="' + e.data.logos_show + '" slide="' + e.data.logos_slide + '" id="' + e.data.logos_ids + '" order="' + e.data.logos_order + '" orderby="' + e.data.logos_orderby + '"]');
							}
						});
					}
				},
				{
					text: dgts.testimonials_carousel_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.testimonials_carousel_options,
							body: [
								{
									type: 'textbox',
									name: 'testimonials_show',
									label: dgts.testimonials_carousel_show,
									value: ''
								},
								{
									type: 'textbox',
									name: 'testimonials_slide',
									label: dgts.testimonials_carousel_slide,
									value: '1'
								},
								{
									type: 'textbox',
									name: 'testimonials_ids',
									label: dgts.testimonials_carousel_ids,
									value: ''
								},
								{
									type: 'listbox',
									name: 'testimonials_order',
									label: dgts.testimonials_carousel_order,
									'values': [
										{text: dgts.descending, value: 'DESC'},
										{text: dgts.ascending, value: 'ASC'}
									]
								},
								{
									type: 'listbox',
									name: 'testimonials_orderby',
									label: dgts.orderby,
									'values': [
										{text: dgts.by_date, value: 'date'},
										{text: dgts.by_ID, value: 'ID'},
										{text: dgts.by_modified, value: 'modified'},
										{text: dgts.by_rand, value: 'rand'}
									]
								}
							],
							onsubmit: function( e ) {
								editor.insertContent( '[testimonials_carousel show="' + e.data.testimonials_show + '" slide="' + e.data.testimonials_slide + '" id="' + e.data.testimonials_ids + '" order="' + e.data.testimonials_order + '" orderby="' + e.data.testimonials_orderby + '"]');
							}
						});
					}
				},
				{
					text: dgts.team_members_shortcode,
					onclick: function() {
						editor.windowManager.open( {
							title: dgts.team_members_options,
							body: [
								{
									type: 'listbox',
									name: 'team_carousel',
									label: dgts.team_members_carousel,
									'values': [
										{text: dgts.no, value: 'no'},
										{text: dgts.yes, value: 'yes'}
									]
								},
								{
									type: 'textbox',
									name: 'team_show',
									label: dgts.team_members_show,
									value: ''
								},
								{
									type: 'textbox',
									name: 'team_slide',
									label: dgts.team_members_slide,
									value: '4'
								},
								{
									type: 'textbox',
									name: 'team_ids',
									label: dgts.team_members_ids,
									value: ''
								},
								{
									type: 'listbox',
									name: 'team_order',
									label: dgts.team_members_order,
									'values': [
										{text: dgts.descending, value: 'DESC'},
										{text: dgts.ascending, value: 'ASC'}
									]
								},
								{
									type: 'listbox',
									name: 'team_orderby',
									label: dgts.orderby,
									'values': [
										{text: dgts.by_date, value: 'date'},
										{text: dgts.by_ID, value: 'ID'},
										{text: dgts.by_modified, value: 'modified'},
										{text: dgts.by_rand, value: 'rand'}
									]
								}
							],
							onsubmit: function( e ) {
								editor.insertContent( '[team_members carousel="' + e.data.team_carousel + '" show="' + e.data.team_show + '" slide="' + e.data.team_slide + '" id="' + e.data.team_ids + '" order="' + e.data.team_order + '" orderby="' + e.data.team_orderby + '"]');
							}
						});
					}
				}
			]
		});
	});
})();