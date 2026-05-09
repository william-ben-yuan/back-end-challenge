import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { API_URL } from '../core/config/api';
import { Track } from '@app/models/track.model';
import { throwError } from 'rxjs/internal/observable/throwError';
import { catchError } from 'rxjs/internal/operators/catchError';
import { Pagination } from '@app/models/pagination.model';

@Injectable({
  providedIn: 'root',
})
export class TracksService {
  private api = API_URL + '/tracks/';

  constructor(private http: HttpClient) {}

  getTracks() {
    return this.http.get<Pagination<Track>>(this.api);
  }

  importTrack(data: { isrc: string }) {
    return this.http.post<Track[]>(this.api, data);
  }
}
