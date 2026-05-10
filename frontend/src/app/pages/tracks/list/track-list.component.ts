import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

import { TracksService } from '@services/track.service';
import { Track } from '@models/track.model';
import { Pagination } from '@app/models/pagination.model';

@Component({
  selector: 'app-tracks-list',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './track-list.component.html',
  styleUrls: ['./track-list.component.css'],
})
export class TrackListComponent implements OnInit {
  private tracksService = inject(TracksService);

  tracks = signal<Pagination<Track> | null>(null); // Sinal para armazenar os dados de tracks pois está zoneless
  error = signal<string>('');
  loading = signal<boolean>(false);

  ngOnInit(): void {
    this.loadTracks();
  }

  loadTracks(): void {
    this.error.set('');
    this.loading.set(true);
    this.tracksService.getTracks().subscribe({
      next: (response) => {
        this.tracks.set(response);
        this.loading.set(false);
      },
      error: (error) => {
        this.error.set('Erro ao carregar tracks');
        this.loading.set(false);
      },
    });
  }
}
