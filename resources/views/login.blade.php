<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
</head>
<body>
    <div class="h-screen bg-white">
        <div class="w-1/3 mx-auto bg-gray-700 rounded-b-lg shadow-lg p-5 text-white">
            <h1 class="text-2xl text-white"><strong>Simple</strong>Pass</h1>

            <div class="mt-3">
                <form method="post" action="{{ route('simplepass.login') }}">
                    <label class="text-sm">Password</label>
                    <input type="password" name="password" class="rounded border border-gray-500 bg-gray-600 py-2 px-4 block w-full" />

                    <div class="flex justify-end mt-2">
                        <button type="submit" class="bg-blue-600 rounded py-2 px-4">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
