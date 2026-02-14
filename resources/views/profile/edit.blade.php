<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-2xl font-bold text-white">Profil</h2>

            <div class="p-6 bg-slate-800 rounded-2xl border border-white/10 shadow-lg shadow-black/10">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-slate-800 rounded-2xl border border-white/10 shadow-lg shadow-black/10">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-slate-800 rounded-2xl border border-white/10 shadow-lg shadow-black/10">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
