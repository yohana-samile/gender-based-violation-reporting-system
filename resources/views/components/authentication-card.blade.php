<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden; /* Prevents vertical scrolling */
    }
    .container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        min-height: 40vh;
        padding: 20px;
        width: 450px;
        border-radius: 10px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
</style>

<div class="flex flex-col justify-center items-center min-h-screen pt-6 sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="container min-h-screen text-center sm:max-w-md px-4 py-4 overflow-hidden sm:rounded-lg bg-white">
        {{ $slot }}
    </div>
</div>
