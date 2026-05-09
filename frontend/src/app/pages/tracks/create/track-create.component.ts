import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

import { TracksService } from '@services/track.service';
import { HttpErrorResponse } from '@angular/common/http';
import { catchError } from 'rxjs/internal/operators/catchError';
import { throwError } from 'rxjs';

@Component({
  selector: 'app-tracks-create',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './track-create.component.html',
  styleUrls: ['./track-create.component.css'],
})
export class TrackCreateComponent implements OnInit {
  private service = inject(TracksService);
  private router = inject(Router);

  isrc: string = '';
  error: string = '';
  loading: boolean = false;

  ngOnInit() {
    this.error = '';
  }

  submit() {
    this.error = '';
    this.loading = true;

    this.service.importTrack({ isrc: this.isrc }).subscribe({
      next: () => {
        this.loading = false;
        //this.router.navigate(['/']); // volta pra lista e recarrega
      },
      error: (err: Error) => {
        this.error = err?.message || 'Erro ao importar track';
        this.loading = false;
      },
    });
  }
}
