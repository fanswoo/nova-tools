import '@fanswoo/core/bootstrap/bootstrap';
import '@fanswoo/core/libraries/jquery/form';

import { Middleware } from '@fanswoo/controller/main';

export default class BaseMiddleware extends Middleware {
  handle(): void {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
    });
  }
}
