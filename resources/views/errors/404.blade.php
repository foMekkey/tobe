<!DOCTYPE html>
@extends('errors.layout')

@section('error-icon', 'fa-map-marker')
@section('error-code', '404')
@section('error-title', __('site.page_not_found'))
@section('error-description', __('site.page_not_found_message'))
function goBack() {
window.history.back();
}
</script>
</body>

</html>
