@push('after_scripts')

    <script>
        if (typeof registerShowDetailLinkOnTestSummaryAction != "function") {
            function registerShowDetailLinkOnTestSummaryAction() {
                var $modal = $(
                    '<div class="modal fade dtr-bs-modal" role="dialog">' +
                    '<div class="modal-dialog" role="document">' +
                    '<div class="modal-content">' +
                    "</div>" +
                    "</div>"
                );
                $("#crudTable tbody td .test-summary--show-user-detail").on(
                    "click",
                    function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        console.log(e);
                        if ("detailLoaded" in e.currentTarget.dataset) {
                            $(
                                "#" + "testSummaryUser" + e.currentTarget.dataset.userId
                            ).modal();
                        } else {
                            $.ajax({
                                    url: e.currentTarget.dataset.detailLink,
                                    type: "GET",
                                })
                                .done(function (data) {
                                    var $content = $modal.find("div.modal-content");
                                    $content.empty().append(data);
                                    $modal
                                        .attr(
                                            "id",
                                            "testSummaryUser" +
                                            e.currentTarget.dataset.userId
                                        )
                                        .appendTo("body")
                                        .modal();
                                    e.currentTarget.dataset.detailLoaded = true;
                                })
                                .fail(function (data) {
                                    console.error(data);
                                });
                        }
                    }
                );
            }
        }
        crud.addFunctionToDataTablesDrawEventQueue(
            "registerShowDetailLinkOnTestSummaryAction"
        );

    </script>
@endpush
