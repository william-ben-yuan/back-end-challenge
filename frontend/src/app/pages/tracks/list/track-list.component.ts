import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

import { TracksService } from '@services/track.service';
import { Track } from '@models/track.model';

@Component({
  selector: 'app-tracks-list',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './track-list.component.html',
  styleUrls: ['./track-list.component.css']
})
export class TracksListComponent implements OnInit {

  private tracksService = inject(TracksService);

  tracks: Track[] = [];

  ngOnInit(): void {
    this.loadTracks();
  }

  loadTracks(): void {
    this.tracksService.getTracks().subscribe({
      next: (response) => {
        this.tracks = response;
      },
      error: (error) => {
        console.error('Erro ao carregar tracks:', error);
      }
    });
  }
}