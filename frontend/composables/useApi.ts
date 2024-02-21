import type {UseFetchOptions} from "#app";

export const useApi = (path: string, options: UseFetchOptions<any> = {}) => {
  const config = useRuntimeConfig();
  let headers: any = {
    accept: "application/json",
    referer: config.public.app_url,
  };

  const token = useCookie('XSRF-TOKEN');

  if (token.value) {
    headers['X-XSRF-TOKEN'] = token.value as string;
  }

  /*if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(["cookie"]),
      referer: config.public.api_url,
    }
  }*/

  return useFetch(config.public.api_url + path, {
    credentials: "include",
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers
    }
  });
}
