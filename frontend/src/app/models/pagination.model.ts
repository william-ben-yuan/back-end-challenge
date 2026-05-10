export interface Pagination<T> {
  data: T[];
  total: number;
  page: number;
  per_page: number;
  last_page: number;
  current_page: number;
}
