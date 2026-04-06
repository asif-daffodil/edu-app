<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 leading-tight">Contact Messages</h2>
                <p class="mt-1 text-sm text-slate-500">Review visitor enquiries submitted from the public contact page.</p>
            </div>

            <div class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-sm font-semibold text-amber-800 ring-1 ring-amber-200">
                Unread: {{ $unreadCount }}
            </div>
        </div>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
        <style>
            .dataTables_wrapper .dataTables_length select {
                padding-right: 2rem !important;
                padding-left: 0.75rem !important;
                background-position: right 0.5rem center !important;
                background-repeat: no-repeat !important;
            }
        </style>
    @endpush

    <div class="space-y-6">
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
            <div class="grid gap-4 md:grid-cols-[220px_auto] md:items-end">
                <div>
                    <label for="contact-message-status-filter" class="block text-sm font-medium text-slate-700">Status</label>
                    <select id="contact-message-status-filter" class="mt-1 w-full rounded-lg border-slate-300">
                        <option value="all">All</option>
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                    </select>
                </div>

                <p class="text-sm text-slate-500">Use the table search to find messages by name, email, phone, subject, or message content.</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto p-4">
                <table id="contact-messages-table" class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">SL</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Visitor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Subject</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Received</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white"></tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {
                var table = $('#contact-messages-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('dashboard.contact-messages.index') }}',
                        data: function (d) {
                            d.status = $('#contact-message-status-filter').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'visitor', name: 'name', orderable: false },
                        { data: 'subject', name: 'subject', orderable: false },
                        { data: 'status_badge', name: 'read_at', searchable: false },
                        { data: 'received_at', name: 'created_at' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false },
                    ],
                    order: [[4, 'desc']],
                });

                $('#contact-message-status-filter').on('change', function () {
                    table.ajax.reload();
                });
            });
        </script>
    @endpush
</x-app-layout>
