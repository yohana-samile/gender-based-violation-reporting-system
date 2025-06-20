<div id="reschonousCpanel" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
   <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full relative">
         <button onclick="closeModal('reschonousCpanel')" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-times text-xl"></i>
         </button>

         <h2>Re-update your data from Cpanel</h2>
         <p class="text-yellow-500">This Action May take several minutes to complete</p>
         <div class="text-center">
            <x-loader />
         </div>
         <form action="{{ route('backend.async.accounts') }}" method="POST" id="async_accounts">
            @csrf
            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded mt-4 mb-3 float-end"> <i class="fas fa-recycle"></i>
                {{__('label.reschonous')}}
            </button>
         </form>
   </div>
</div>
