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

  ngOnInit(): void {
    this.loadTracks();
  }

  loadTracks(): void {
    this.tracksService.getTracks().subscribe({
      next: (response) => {
        this.tracks.set(response);
      },
      error: (error) => {
        console.error('Erro ao carregar tracks:', error);
      },
    });
  }
}
