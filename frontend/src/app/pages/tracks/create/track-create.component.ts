import { Component, inject, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';

import { TracksService } from '@services/track.service';
import { HttpErrorResponse } from '@angular/common/http';

@Component({
  selector: 'app-tracks-create',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './track-create.component.html',
  styleUrls: ['./track-create.component.css'],
})
export class TrackCreateComponent implements OnInit {
  private service = inject(TracksService);
  private router = inject(Router);

  isrc: string = '';
  error = signal<string>(''); // Sinal para armazenar mensagens de erro, pois está zoneless
  loading = signal<boolean>(false);

  ngOnInit() {
    this.error.set('');
  }

  submit() {
    this.error.set('');
    this.loading.set(true);

    this.service.importTrack({ isrc: this.isrc }).subscribe({
      next: () => {
        this.loading.set(false);
        this.router.navigate(['/']); // volta pra lista e recarrega
      },
      error: (err: HttpErrorResponse) => {
        this.loading.set(false);
        this.error.set(err?.error?.error || 'Erro ao importar track');
      },
    });
  }
}
