import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Pagination } from '@app/models/pagination.model';
import { Track } from '@app/models/track.model';

@Component({
  selector: 'app-tracks-table',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './track-table.component.html',
  styleUrls: ['./track-table.component.css'],
})
export class TracksTableComponent {
  @Input() tracks!: Pagination<Track>;
}
