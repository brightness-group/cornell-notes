<div class="card p-0 overflow-hidden h-full">
    <div class="flex justify-between items-center p-2">
        <h2>
            <a href="{{ cp_route('customers.index') }}" class="flex items-center">
                <div class="h-6 w-6 mr-1 text-grey-80">
                    @cp_svg('users-box')
                </div>
                <span>{{ __('Newest Users') }}</span>
            </a>
        </h2>
    </div>

    <div>
        <div>
            <table tabindex="0" class="data-table">
                <tbody tabindex="0">
                    @foreach ($users as $user)
                        <tr class="outline-none">
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ cp_route('customers.edit', $user->id) }}">{{ $user->name }}</a>
                                </div>
                            </td>
                            <td class="text-right">
                                {{ $user->created_at->format(config('statamic.cp.date_format')) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
