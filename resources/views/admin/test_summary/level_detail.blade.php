<div class="modal-header">
    <h4 class="modal-title"></h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <table class="table table-striped mb-0">
        <thead>
            <tr>
                <td>お名前：{{ $user->name }}</td>
                <td>レベル{{ $level }}</td>
            </tr>
            <tr>
                <th class="text-right">試験日</th>
                <th>結果</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testResults as $testResult)
                <tr>
                    <td class="text-right">{{ (new DateTime($testResult->created_at))->format("Y/m/d H:i") }}</td>
                    <td>{{ $testResult->number_of_corrects >=4 ? '合格' : '不合格' }}({{ $testResult->number_of_corrects }}/{{ $testResult->number_of_questions }})</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
