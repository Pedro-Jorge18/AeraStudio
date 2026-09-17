import { DatabaseSync } from 'node:sqlite';
import path from 'node:path';

// Usa o SQLite embutido no Node (node:sqlite) — sem módulos nativos, sem compilação,
// sem Python nem build tools. Aponta para a MESMA base de dados de sempre.
const caminhoBd = path.join(process.cwd(), 'db', 'aera_studio.sqlite');

let _db: DatabaseSync | null = null;

export function db(): DatabaseSync {
  if (_db) return _db;
  _db = new DatabaseSync(caminhoBd);
  _db.exec('PRAGMA foreign_keys = ON');
  return _db;
}

/** Converte um array de strings num JSON compacto, ou null se ficar vazio. */
export function paraJson(valores: string[]): string | null {
  const v = valores.map((s) => s.trim()).filter((s) => s !== '');
  return v.length ? JSON.stringify(v) : null;
}

/** Divide texto multi-linha num array de strings não vazias, sem espaços à volta. */
export function linhasParaArray(texto: string): string[] {
  return texto
    .split(/\r\n|\r|\n/)
    .map((s) => s.trim())
    .filter((s) => s !== '');
}

/** Inverso de paraJson — devolve sempre um array (vazio se não houver nada). */
export function deJson(json: string | null | undefined): string[] {
  if (!json) return [];
  try {
    const v = JSON.parse(json);
    return Array.isArray(v) ? v : [];
  } catch {
    return [];
  }
}

/** Data de hoje em formato AAAA-MM-DD (equivalente ao date('Y-m-d') do PHP). */
export function hojeISO(): string {
  return new Date().toISOString().slice(0, 10);
}

/** Data daqui a N dias em formato AAAA-MM-DD. */
export function maisDiasISO(dias: number): string {
  const d = new Date();
  d.setDate(d.getDate() + dias);
  return d.toISOString().slice(0, 10);
}
