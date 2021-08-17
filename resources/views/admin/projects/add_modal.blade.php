<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('title.add_modal') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ trans('title.name') }}</label>
                        <input class="form-control" name="name" id="addName">
                    </div>
                    @if($type == \App\Http\Enum\EnumProjects::REQUIREMENTS)
                        <div class="form-group">
                            <label for="addParent">{{ trans('title.system') }}</label>
                            <select class="form-control" id="addParent">
                                @foreach($systemList as $system)
                                    <option value="{{ $system->id }}">{{ $system->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($type == \App\Http\Enum\EnumProjects::SUBFUNCTIONS)
                        <div class="form-group">
                            <label for="addSystem">{{ trans('title.system') }}</label>
                            <select class="form-control" name="system" id="addSystem">
                                @foreach($systems as $system)
                                    <option value="{{ $system->id }}">{{ $system->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addRequirement">{{ trans('title.function') }}</label>
                            <select class="form-control" name="requirement_id" id="addParent">
                                @foreach($systems as $system)
                                    @foreach($system->requirements as $requirement)
                                        <option value="{{ $requirement->id }}"
                                                name="{{ $requirement->system_id }}">{{ $requirement->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <input type="hidden" id="addParent" value="{{ $project->id }}">
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="name">{{ trans('title.ios_cost') }}</label>
                                <input class="form-control" name="ios_cost" id="addIos" type="number" min="0">
                            </div>
                            <div class="col-4">
                                <label for="name">{{ trans('title.android_cost') }}</label>
                                <input class="form-control" name="android_cost" id="addAndroid" type="number" min="0">
                            </div>
                            <div class="col-4">
                                <label for="name">{{ trans('title.web_cost') }}</label>
                                <input class="form-control" name="web_cost" id="addWeb" type="number" min="0">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="addId" name="addId" value="0">
                    <div class="form-group">
                        <label for="addPriority">{{ trans('title.priority') }}</label>
                        <select name="priority" id="addPriority" class="form-control">
                            <option value="high">{{ trans('title.high') }}</option>
                            <option value="medium">{{ trans('title.medium') }}</option>
                            <option value="low">{{ trans('title.low') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ trans('title.memo') }}</label>
                        <input class="form-control" name="name" id="addMemo">
                    </div>
                </div>
            </div>
            <input type="hidden" id="type">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('title.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="Helper.addSave('{{ $type }}')">{{ trans('title.save_changes') }}
                </button>
            </div>
        </div>
    </div>
</div>