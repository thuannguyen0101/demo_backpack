<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="editForm">
            @csrf
            @method("PUT")
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('title.edit_modal') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">{{ trans('title.name') }}</label>
                    <input class="form-control" name="name" id="editName">
                </div>
                <input type="hidden" id="editType">
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="name">{{ trans('title.ios_cost') }}</label>
                            <input class="form-control" name="ios_cost" id="editIos" type="number" min="0">
                        </div>
                        <div class="col-4">
                            <label for="name">{{ trans('title.android_cost') }}</label>
                            <input class="form-control" name="android_cost" id="editAndroid" type="number" min="0">
                        </div>
                        <div class="col-4">
                            <label for="name">{{ trans('title.web_cost') }}</label>
                            <input class="form-control" name="web_cost" id="editWeb" type="number" min="0">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="editId" name="editId" value="0">
                <div class="form-group">
                    <label for="name">{{ trans('title.priority') }}</label>
                    <select name="priority" id="editPriority" class="form-control">
                        <option value="high">{{ trans('title.high') }}</option>
                        <option value="medium">{{ trans('title.medium') }}</option>
                        <option value="low">{{ trans('title.low') }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">{{ trans('title.memo') }}</label>
                    <input class="form-control" name="name" id="editMemo">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('title.close') }}</button>
                <button type="button" class="btn btn-primary" id="editSave">{{ trans('title.save_changes') }}</button>
            </div>
        </form>
    </div>
</div>
