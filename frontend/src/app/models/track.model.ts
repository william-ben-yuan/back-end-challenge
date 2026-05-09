import { Artist } from "./artist.model";

export interface Track {
  id: string;
  isrc: string;
  title: string;
  releaseDate: string;
  duration: number;
  artists: Artist[] | null;
  album_thumbnail_url: string;
  preview_url: string;
  spotify_url: string;
  is_available_in_brazil: boolean;
}