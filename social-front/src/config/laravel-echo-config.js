import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
// window.Echo = new Echo({
//   broadcaster: 'pusher',
//   key: 'chatroom',
//   cluster: 'chatroom',
//   wsHost: '127.0.0.1',
//   wsPort: 6001,
//   forceTLS: false,
//   disableStats: true,
//   authEndpoint: 'http://localhost:8000/api/broadcasting/auth', // Use the correct URL
//   auth: {
//     headers: {
//       Authorization: `Bearer 25|cOidUfZhu4zTEgjMxl4CWYMGQEHAkbJw9E8xnPhP`,
//     },
//   },
// });

export default window.Echo;