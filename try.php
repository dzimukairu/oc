							<div id="quiz_identification" class="form-group">
								<label>
									<input id="toggle1" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enable" data-on-text="Enable" data-off="Disable" data-off-text="Disable" type="checkbox">
									Identification
								</label>
								<div id="identification">
									<input type="button" value="Add Row" onclick="addRow('identificationTable')" class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('identificationTable')"  class="btn btn-danger"/>
									<br>
									<br>
									<table id="identificationTable" class="table">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td style="width: 20px"><p>1</p></td>
											<td><input type="text" name="identification_question[]" class="form-control" value="" placeholder="Enter question here." /></td>

								<textarea data-autoresize rows="2" class="form-control expand_this" id="identification_question[]" name="identification_question[]" value="" placeholder="Enter question here." ></textarea>
											<td><input type="text" name="identification_answer[]" class="form-control" value="" placeholder="Enter answer here." /></td>
										</tr>
									</table>
									<input type="hidden" id="identificationTable_length" name="identificationTable_length" value=0/>
								</div>
							</div>
							<div id="quiz_multipleChoice" class="form-group">
								<label>
									<input id="toggle2" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enable" data-off="Disable" type="checkbox">
									Multiple Choice
								</label>
								<div id="multipleChoice">
									<input type="button" value="Add Row" onclick="addRow('multipleChoiceTable')"  class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('multipleChoiceTable')"  class="btn btn-danger"/>
									<br>
									<br>

									<table id="multipleChoiceTable" class="table table-hover">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td><p>1</p></td>
											<td><input type="text" name="multipleChoice_question[]" class="form-control" placeholder="Enter question here." /></td>
											<td><input type="text" name="multipleChoice_choices[]" class="form-control" placeholder="Enter choices here (separated by comma)" /></td>
											<td><input type="text" name="multipleChoice_answer[]" class="form-control" placeholder="Enter answer here." /></td>
										</tr>
									</table>
									<input type="hidden" id="multipleChoiceTable_length" name="multipleChoiceTable_length" value=0/>
								</div>
							</div>
							<div id="quiz_multipleAnswer" class="form-group">
								<label>
									<input id="toggle3" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enable" data-off="Disable" type="checkbox">
									Multiple Answers
								</label>
								<div id="multipleAnswer">
									<input type="button" value="Add Row" onclick="addRow('multipleAnswerTable')"  class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('multipleAnswerTable')"  class="btn btn-danger"/>
									<br>
									<br>

									<table id="multipleAnswerTable" class="table table-hover">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td style="width: 20px"><p>1</p></td>
											<td><input type="text" name="multipleAnswer_question[]" class="form-control" placeholder="Enter question here." /></td>
											<td><input type="text" name="multipleAnswer_choices[]" class="form-control" placeholder="Enter choices here (separated by comma)" /></td>
											<td><input type="text" name="multipleAnswer_answer[]" class="form-control" placeholder="Enter answer here." /></td>
										</tr>
									</table>
									<input type="hidden" id="multipleAnswerTable_length" name="multipleAnswerTable_length" value=0/>
								</div>
							</div>