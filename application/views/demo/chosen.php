<br/>
<?= form_select(states_array(), false, 'class="demo" data-placeholder="Add a state"', '') ?>
<br/>
<?= form_select(states_array(), false, 'class="demo" data-placeholder="Add a state" multiple', '') ?>
<br/>
<br/>
<a href="/assets/plugins/chosen/options.html">options</a>
<br/><br/>
<a href="/assets/plugins/chosen/index.html">docs</a>

<script>
 $(".demo").chosen({
 	//allow_single_deselect: true
 	//disable_search: true,
 	//enable_split_word_search: true,
    disable_search_threshold: 10,
    placeholder_text_single: 'Select a State',
    no_results_text: "No Results for",
    inherit_select_classes: true,
    search_contains: true,
    width: '40%',
    display_disabled_options: false
  });
</script>