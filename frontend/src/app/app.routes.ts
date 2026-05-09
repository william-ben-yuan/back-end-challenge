import { Routes } from '@angular/router';
import { TrackListComponent } from './pages/tracks/list/track-list.component';
import { TrackCreateComponent } from './pages/tracks/create/track-create.component';

export const routes: Routes = [
  {
    path: '',
    component: TrackListComponent,
  },
  {
    path: 'create',
    component: TrackCreateComponent,
  },
];
