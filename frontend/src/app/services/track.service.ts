import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { API_URL } from '../core/config/api';
import { Track } from '@app/models/track.model';
import { Pagination } from '@app/models/pagination.model';

@Injectable({
  providedIn: 'root',
})
export class TracksService {
  private api = API_URL + '/tracks/';

  constructor(private http: HttpClient) {}

  getTracks($page: number = 1) {
    return this.http.get<Pagination<Track>>(`${this.api}?page=${$page}`);
  }

  importTrack(data: { isrc: string }) {
    return this.http.post<Track[]>(this.api, data);
  }
}
