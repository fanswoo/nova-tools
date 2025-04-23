import $ from 'jquery';

export default abstract class Controller {
  protected middlewares: any[] = [];

  constructor(arg: { middlewares: any[] }) {
    const { middlewares } = arg;
    this.middlewares = middlewares;

    $(() => {
      this.runMiddleware();
      this.ready();
    });
  }

  runMiddleware() {
    this.middlewares.forEach(MiddlewareClass => {
      const AnyMiddlewareClass = MiddlewareClass as any;
      const middleware = new AnyMiddlewareClass();

      if (typeof middleware.handle !== 'function') {
        throw new Error('middleware needs handle method.');
      }
      middleware.handle();
    });
  }

  abstract ready(): void;
}
