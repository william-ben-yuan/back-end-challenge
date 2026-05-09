import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { API_URL } from '../core/config/api';
import { Track } from '@app/models/track.model';

@Injectable({
  providedIn: 'root'
})
export class TracksService {

  private api = API_URL + '/tracks/';

  constructor(private http: HttpClient) {}

  getTracks() {
    return this.http.get<Track[]>(this.api);
  }

  importTrack(string: any) {
    return this.http.post<Track[]>(`${this.api}${string}`, {});
  }
}