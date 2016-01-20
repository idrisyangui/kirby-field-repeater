<div class="repeater">

	<?php echo $field->headline() ?>

	<!-- <input class="hidden" type="text" v-model="values" value="<?php echo a::json($field->values()); ?>">
	<input class="hidden" type="text" v-model="blueprint" value="<?php echo a::json($field->values()); ?>">
	<input class="hidden" type="text" v-model="fields" value="<?php echo a::json($field->values()); ?>">
 -->
	<div class="repeater-entries">

		<div class="structure-entries structure-entry" v-sortable:values="{ animation: 200 }">
			<div class="repeater-entry"  v-for="(v_index ,value) in values">
				<div class="repeater-entry-content text" v-if="editedEntries[v_index]">
					<label class="builder-entry-fieldset">{{section}}</label>
					<div class="field-content" v-for="(f_index, field) in fields | orderBy 'f_index' 1">
						<component
							:is="field.type"
					    :inputlabel="field.label"
					    :inputvalue.sync="value[f_index]"
					    :inputoptions="field.options">
					  </component>
					</div>
				</div>

				<div class="repeater-entry-content text" v-else>
			    <?php echo $field->entry() ?>
			  </div>

				<div class="repeater-entry-options cf" >
					<div class="repeater-btn repeater-edit-button" v-on:click="editEntrie(v_index)" v-if="editedEntries[v_index]"> <?php i('check', 'left') ?></div>
					<div class="repeater-btn repeater-edit-button" v-on:click="editEntrie(v_index)" v-else> <?php i('pencil', 'left') ?></div>
					<div class="repeater-btn repeater-delete-button" v-on:click="removeEntrie(v_index)" > <?php i('trash-o', 'left') ?></div>
					<div class="repeater-btn repeater-order-button"  > <?php i('arrows', 'left') ?></div>
				</div>
				<div class="repeater-entry-separator">
					<div class="repeater-btn repeater-add-button fa fa-plus-circle" v-on:click="addEntrie(v_index)"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <pre>{{ editedEntries | json 4}}</pre>
<pre>{{ editedEntries | json 4}}</pre> -->
<!-- <pre>{{ fields | json 4}}</pre>
<pre>{{ values | json 4}}</pre>
<pre>{{ yamlvalues }}</pre>
 -->

<?php foreach ($field->fields() as $f => $s ) { $blueprint[$f] = ""; }?>


<!-- component template -->
<template id="input_template_text">
	<label>{{inputlabel}}</label><br>
	<input class="input" v-model="inputvalue">
	<br>
</template>

<template id="input_template_textarea">
	<label>{{inputlabel}}</label><br>
	<textarea class="input" v-model="inputvalue">{{inputvalue}}</textarea>
</template>

<template id="input_template_radio">
	<label>{{inputlabel}}</label><br>
	<template v-for="(o_index, option) in inputoptions">
		<input type="radio" id="{{o_index}}" value="{{o_index}}" v-model="inputvalue">
		<label for="{{o_index}}"> {{option}}	</label>
	</template>
	<br>
</template>

<template id="input_template_select">
	<label>{{inputlabel}}</label><br>
	<select v-model="inputvalue">
		<template v-for="(o_index, option) in inputoptions">
			<option  v-bind:value="o_index">
				{{ option }}
			</option>
		</template>
	</select>
	<br>
</template>

<script type="text/javascript">
(function($) {

		var vm_<?php echo $field->fieldid(); ?> = new Vue({
			el: '.<?php echo $field->fieldid(); ?>',
			data: {
				message : "Liste des entrées",
				values : <?php echo a::json($field->values(), JSON_FORCE_OBJECT); ?>,
				blueprint : <?php echo a::json($blueprint); ?>,
				fields : <?php echo a::json($field->fields()); ?>,
				editedEntries : {},
				datatboby : {},

			},
			created: function () {

			},
			computed: {

				yamlvalues: function () {
					return YAML.stringify(this.values);
				},
				section: function (){
					return message
				},
				records: function (){
					return this.values
				}
			},
			// watch:{

			// },
			methods:{
				addEntrie: function (v_index){
					newEntrie =  <?php echo a::json($blueprint); ?>;
					this.values.push(newEntrie);
				},
				editEntrie: function (v_index){

					if (this.editedEntries[v_index]) {
						Vue.set(this.editedEntries, v_index, 0);
					}else{
						Vue.set(this.editedEntries, v_index, 1);
					};

					console.log(this.editedEntries);
				},
				removeEntrie: function (index){
					this.values.splice(index, 1);
					this.editedEntries.splice(index, 1);
				},
				inputTemplate: function (inputType){
					return "cinput" + inputType;
				}
			},
			components:{
				text: {
				  template: '#input_template_text',
				  props: {
				    inputvalue: String,
				    inputlabel: String,
				  }
				},
				longtext: {
				  template: '#input_template_textarea',
				  props: {
				    inputvalue: String,
				    inputlabel: String,
				  }
				},
				radio: {
				  template: '#input_template_radio',
				  props: {
				    inputvalue: String,
				    inputlabel: String,
				    inputoptions: Object,
				  }
				},
			},
			directives:{
				data: function (value) {
				}
			},
			events: {
				sort: function( item, e ) {
					editedEntrieItem = this.editedEntries[e.oldIndex];
					Vue.set(this.editedEntries, e.oldIndex, this.editedEntries[e.newIndex]);
					Vue.set(this.editedEntries, e.newIndex, editedEntrieItem);
					// console.log( item );
					// console.log( e );
				}
			}
		});

})(jQuery);

</script>
