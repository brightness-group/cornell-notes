<div class="card p-0 overflow-hidden h-full">
    <div class="flex justify-between items-center p-2">
        <h2>
            <a href="{{ cp_route('customers.index') }}" class="flex items-center">
                <div class="h-6 w-6 mr-1 text-grey-80">
                    @cp_svg('user_groups')
                </div>
                <span>{{ __('Users Overview') }}</span>
            </a>
        </h2>
    </div>

    <div>
        <div>
            <table tabindex="0" class="data-table">
                <tbody tabindex="0">
                    <tr class="outline-none">
                        <td>{{ __('Total Users') }}</td>
                        <td class="text-right">{{ $total }}</td>
                    </tr>

                    <tr class="outline-none">
                        <td>{{ __('Subscribed Users') }}</td>
                        <td class="text-right">{{ $subscribed }}</td>
                    </tr>

                    <tr class="outline-none">
                        <td>{{ __('Canceled Users') }}</td>
                        <td class="text-right">{{ $canceled }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
